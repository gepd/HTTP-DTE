<?php

include_once("./error.php");
include_once("./helper.php");

/**
 * Genera DTE y/o lo envía si es que el parametro previsualizar es igual a false.
 * Cuando el envío es exitoso devuelve el TrackID.
 * Si el parametro previsualizar es true, devuelve el sobre con el DTE
 * 
 * @param firma array con firma para generar documento, este array debe contener
 *  los campos 'data' y 'pass'
 * @param folios folios para enviar el documento
 * @param caratula array con caratula para generar DTE ('RutReceptor', 'FchResol', 'NroResol')
 * @param documento array con valores para generar documentos, este valor variará dependiendo
 * del tipo de de documento a enviar
 * @param previsualizar si el valor es true no enviará el documento al SII y devolverá array con DTE
 * y EnvioDTE, si el valor es False, enviará el documento y retornará array con DTE y TrackId
 */
function DTE($firma, $folios, $caratula, $documento, $previsualizar = false)
{
    // Objetos de Firma y Folios
    $firma = new \sasco\LibreDTE\FirmaElectronica($firma);
    $folios = new \sasco\LibreDTE\Sii\Folios($folios);

    // Generar XML del DTE timbrado y firmado
    $DTE = new \sasco\LibreDTE\Sii\Dte($documento);
    $DTE->timbrar($folios);
    $DTE->firmar($firma);

    // Generar sobre con el envío del DTE y enviar al SII
    $EnvioDTE = new \sasco\LibreDTE\Sii\EnvioDte();
    $EnvioDTE->agregar($DTE);
    $EnvioDTE->setFirma($firma);
    $EnvioDTE->setCaratula($caratula);
    $EnvioDTE->generar();

    if ($EnvioDTE->schemaValidate()) {
        $EnvioDTE->generar();
        if (!$previsualizar) {
            $TrackId = $EnvioDTE->enviar();
            return array("DTE" => $DTE, "TrackId" => $TrackId);
        }
        return array("DTE" => $DTE, "EnvioDTE" => $EnvioDTE);
    }

    // Mostrar error si hubo
    foreach (\sasco\LibreDTE\Log::readAll() as $error)
        echo $error, "\n";

    return false;
}

/**
 * Genera un DTE en PDF basado en la información entregada
 * 
 * @param envioDTE Sobre con envío de un DTE
 * @param logoUrl URL apunto a una imagen PNG para agregar al DTE
 * @param logoIzquierda si el valor es 1 ajusta el logo a la izquierda. Si es 0, arriba.
 * @param pdfName nombre del pdf a generar
 */
function generar_pdf($envioDTE, $logoUrl, $logoIzquierda = 1, $pdfName)
{
    $Documentos = $envioDTE->getDocumentos();
    $caratula = $envioDTE->getCaratula();

    foreach ($Documentos as $DTE) {
        if (!$DTE->getDatos())
            die(get_error("NO_DTE_DATA"));

        $pdf = new \sasco\LibreDTE\Sii\Dte\PDF\Dte(false);

        if ($logoUrl) {
            $pdf->setLogo($logoUrl, $logoIzquierda);
        }

        $pdf->setResolucion(['FchResol' => $caratula['FchResol'], 'NroResol' => $caratula['NroResol']]);
        $pdf->agregar($DTE->getDatos(), $DTE->getTED());
        return $pdf->Output($pdfName, 'I');
    }
}

/**
 * Genera y envía un DTE o genera un PDF
 * @param firma array con firma para generar documento, este array debe contener
 * los campos 'data' (codificado en base64) y 'pass'
 * @param folios array folios para enviar el documento, este array debe contener
 * el campo 'data' codificado en base64
 * @param caratula array con caratula para generar DTE ('RutReceptor', 'FchResol', 'NroResol')
 * @param documento array con valores para agregar en el DTE
 * @param logoUrl URL al logo en formato PNG para agregar al PDF
 * @param query valores obtenidos desde getQueryParams
 */
function generar_documento($firma, $folios, $caratula, $documento, $logoUrl, $query)
{
    // previsualizar o enviar documento
    $previsualizar = (bool)obtener_dato_de_query("previsualizar", 0, $query) + 0;

    // Obtiene la posición del logo
    $logo_izquierda = obtener_dato_de_query("logo_izquierda", 1, $query) + 0;

    // Decodifica la firma que viene en base64
    $firma = obtener_dato_base64($firma, "FIRMA_NO_BASE64");

    // Decodifica los folios que vienen en base64
    $folios = obtener_dato_base64($folios, "FOLIOS_NO_BASE64");

    // Verifica que la fecha tenga el formato yyyy-mm-dd
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $caratula["FchResol"])) {
        die(get_error("FORMATO_FECHA_RESOL"));
    }

    $Resultado = DTE($firma, $folios["data"], $caratula, $documento, $previsualizar);

    $DTE = $Resultado["DTE"];

    if ($previsualizar) {
        $EnvioDTE = $Resultado["EnvioDTE"];
        $pdf_name = 'dte_' . $DTE->getEmisor() . $DTE->getID() . '.pdf';
        $Pdf = generar_pdf($EnvioDTE, $logoUrl, $logo_izquierda, $pdf_name);

        return $Pdf;
    }
    return $Resultado["TrackId"];
}

/**
 * Envía libro con guías de despacho al SII
 * @param firma array con firma electrónica
 * @param caratula array con caratula para generar libro
 * @param documento array con documentos a agregar al libro
 */
function enviar_libro_guia($firma, $caratula, $documento)
{

    // Decodifica la firma que viene en base64
    $firma = obtener_dato_base64($firma, "FIRMA_NO_BASE64");

    // Verifica que la fecha tenga el formato yyyy-mm-dd
    if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $caratula["FchResol"])) {
        die(get_error("FORMATO_FECHA_RESOL"));
    }

    // Objetos de Firma y LibroGuia
    $Firma = new \sasco\LibreDTE\FirmaElectronica($firma);
    $LibroGuia = new \sasco\LibreDTE\Sii\LibroGuia();

    // agregar cada uno de los detalles al libro
    foreach ($documento["Detalle"] as $detalle) {
        $detalle["TasaImp"] = \sasco\LibreDTE\Sii::getIVA();
        $LibroGuia->agregar($detalle);
    }

    // enviar libro de guías y mostrar resultado del envío: track id o bien =false si hubo error
    $LibroGuia->setFirma($Firma);
    $LibroGuia->setCaratula($caratula);
    $LibroGuia->generar();

    if ($LibroGuia->schemaValidate()) {
        $Track_id = $LibroGuia->enviar();
        return json_encode(array("TrackId" => $Track_id));
    }

    // si hubo errores mostrar
    foreach (\sasco\LibreDTE\Log::readAll() as $error)
        echo $error, "\n";

    return false;
}

const LIBRO_COMPRA = "COMPRA";
const LIBRO_VENTA = "VENTA";

/**
 * Envía libro de compra y venta al SII
 * @param firma array con firma electrónica
 * @param caratula array con caratula para generar libro
 * @param archivoParseado archivo csv parseado (array)
 * @param tipoOperacion COMPRA: libro de compra. VENTA: libro de venta
 * @param query array con variables GET
 */
function enviar_libro_compra_venta($firma, $caratula, $archivoParseado, $tipoOperacion, $query)
{
    // Cuando es 1 el libro es simplificado
    $simplificado = (bool)obtener_dato_de_query("simplificado", 0, $query) + 0;

    // Decodifica la firma que viene en base64
    $firma = obtener_dato_base64($firma, "FIRMA_NO_BASE64");

    // Objetos de Firma y LibroCompraVenta
    $Firma = new \sasco\LibreDTE\FirmaElectronica($firma);
    $LibroCompraVenta = new \sasco\LibreDTE\Sii\LibroCompraVenta($simplificado);

    if ($tipoOperacion === LIBRO_COMPRA) {
        $LibroCompraVenta->agregarComprasArray($archivoParseado);
    } elseif ($tipoOperacion === LIBRO_VENTA) {
        $LibroCompraVenta->agregarVentasArray($archivoParseado);
    }

    $LibroCompraVenta->setCaratula($caratula);
    $LibroCompraVenta->generar();
    $LibroCompraVenta->setFirma($Firma);
    $TrackId = $LibroCompraVenta->enviar();

    if ($TrackId) {
        return json_encode(array("TrackId" => $TrackId));
    }

    // si hubo errores mostrar
    foreach (\sasco\LibreDTE\Log::readAll() as $error)
        echo $error, "\n";
}
