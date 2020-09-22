<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Verifica que el string enviado esté codificado en base64
 * @param texto texto codificado a verificar
 * @return boolean true si el texto está codificado en base64
 */
function es_base64($texto)
{
    return $texto and (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $texto);
}

/**
 * Decodifica el campo "data" enviado en el array $codificado
 * @param codificado array con la información codificada
 * @return array información decodificada
 */
function decodificar_dato64($codificado)
{
    $codificado["data"] = base64_decode($codificado["data"]);
    return $codificado;
}

/**
 * Verifica si el array enviado contiene un campo "data" codificado
 * en base64 y mueestra un error si no lo es. Al encontrarlo lo
 * decodifica y lo devuelve.
 * @param dato Array con el campo "data"
 * @param errorName Nombre del error a mostrar (en caso de haber uno)
 * @return array información decodificada
 */
function obtener_dato_base64($dato, $errorName)
{
    if (!es_base64($dato["data"])) {
        die(get_error($errorName));
    }

    return decodificar_dato64($dato);
}

/**
 * Obtiene el valor desde un array, si el valor no existe
 * en el array, se devolverá el valor de porefecto
 * @param key llave a buscar en el array
 * @param default valor a devolver si la llave no existe
 * @return value valor encontrado o valor por defecto
 */
function obtener_dato_de_query($key, $default, $query)
{
    if (array_key_exists($key, $query)) {
        return $query[$key];
    }
    return $default;
}

/**
 * Realiza una petición (emisión/previsualización) de un documento al SII
 * @param data_callback callback usado para parsear los valores enviados
 * en el cuerpo de la petición.
 * @param req Valores de Request
 * @param res Valores de Response
 * @param previsualizar cuando es true el documento solo se generará como un PDF
 */
function peticion_dte($data_callback, Request $req, Response $res)
{
    $body = $req->getParsedBody();
    $query = $req->getQueryParams();
    $es_certificacion = obtener_dato_de_query("certificacion", 0, $query);
    $previsualizar = (bool)obtener_dato_de_query("previsualizar", 0, $query);

    establecer_ambiente($es_certificacion);

    $firma = $body["Firma"];
    $folios = $body["Folios"];
    $logoUrl = $body["LogoUrl"];

    $data = $data_callback($body);

    $result = generar_documento($firma, $folios, $data["Caratula"], $data["Documento"], $logoUrl, $query);

    $res->getBody()->write($result);

    return $res;
}

/**
 * Realiza una petición (emisión) de un libro de guias de despacho al SII
 * @param data_callback callback usado para parsear los valores enviados
 * en el cuerpo de la petición.
 * @param req Valores de Request
 * @param res Valores de Response
 */
function peticion_libro($data_callback, Request $req, Response $res)
{
    $body = $req->getParsedBody();
    $query = $req->getQueryParams();
    $es_certificacion = obtener_dato_de_query("certificacion", 0, $query);

    establecer_ambiente($es_certificacion);

    $firma = $body["Firma"];

    $data = $data_callback($body);

    $result = enviar_libro($firma, $data["Caratula"], $data["Documento"]);

    $res->getBody()->write($result);

    return $res;
}

/**
 * Establece el ambiente y el servidor que será usado (maullin y palena)
 * @param es_certificacion cuando el valor es true la librería será usada en modo certificación
 */
function establecer_ambiente($es_certification)
{
    if ($es_certification) {
        \sasco\LibreDTE\Sii::setAmbiente(\sasco\LibreDTE\Sii::CERTIFICACION);
        \sasco\LibreDTE\Sii::setServidor('maullin');
    } else {
        \sasco\LibreDTE\Sii::setAmbiente(\sasco\LibreDTE\Sii::PRODUCCION);
        \sasco\LibreDTE\Sii::setServidor('palena');
    }
}
