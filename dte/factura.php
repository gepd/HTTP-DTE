<?php

include_once(dirname(__FILE__) . "/dte.php");

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$facturaEstado = function (Request $req, Response $res) {
    $body = $req->getParsedBody();
    $query = $req->getQueryParams();
    $es_certificacion = obtener_dato_de_query("certificacion", 0, $query);

    establecer_ambiente($es_certificacion);

    // Decodifica la firma que viene en base64
    $firma = obtener_dato_base64($body["Firma"], "FIRMA_NO_BASE64");

    // Extrae el RUT sin el digito verificador
    $rut = substr($body["rut"], 0, -1);

    // Extrae solo el dígito verificador
    $dv = substr($body["rut"], -1);

    $trackId = $body["trackId"];

    $token = \sasco\LibreDTE\Sii\Autenticacion::getToken($firma);
    $estado = \sasco\LibreDTE\Sii::request('QueryEstUp', 'getEstUp', [$rut, $dv, $trackId, $token]);

    // Si el estado se pudo recuperar se muestra estado y glosa (json)
    if ($estado !== false) {
        $response = json_encode([
            'codigo' => (string)$estado->xpath('/SII:RESPUESTA/SII:RESP_HDR/ESTADO')[0],
            'glosa' => (string)$estado->xpath('/SII:RESPUESTA/SII:RESP_HDR/GLOSA')[0],
        ]);

        $res->getBody()->write($response);
    }

    // Mostrar error si hubo
    foreach (\sasco\LibreDTE\Log::readAll() as $error)
        echo $error, "\n";

    return $res;
};

$facturaEmitir = function (Request $req, Response $res) {
    $callback = function ($body) {
        $caratula = [
            'RutReceptor' => $body["Receptor"]["RUTRecep"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
        ];

        $documento = [
            'Encabezado' => [
                'IdDoc' => [
                    'TipoDTE' => 33,
                    'Folio' => $body["Folio"],
                ],
                'Emisor' => $body["Emisor"],
                'Receptor' => $body["Receptor"],
            ],
            'Detalle' => $body["Detalle"],
        ];

        return array("Caratula" => $caratula, "Documento" => $documento);
    };

    return peticion_dte($callback, $req, $res);
};

$facturaEmitirExenta = function (Request $req, Response $res) {
    $callback = function ($body) {
        $caratula = [
            'RutReceptor' => $body["Receptor"]["RUTRecep"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
        ];

        $documento = [
            'Encabezado' => [
                'IdDoc' => [
                    'TipoDTE' => 34,
                    'Folio' => $body["Folio"],
                ],
                'Emisor' => $body["Emisor"],
                'Receptor' => $body["Receptor"],
            ],
            'Detalle' => $body["Detalle"],
        ];

        return array("Caratula" => $caratula, "Documento" => $documento);
    };

    return peticion_dte($callback, $req, $res);
};
