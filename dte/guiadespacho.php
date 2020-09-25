<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$guiaDespachoEmitir = function (Request $req, Response $res) {
    $callback = function ($body) {
        $caratula = [
            'RutReceptor' => $body["Receptor"]["RUTRecep"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
        ];

        $documento = [
            'Encabezado' => [
                'IdDoc' => [
                    'TipoDTE' => 52,
                    'Folio' => $body["Folio"],
                    'TipoDespacho' => $body["TipoDespacho"],
                    'IndTraslado' => $body["IndTraslado"],

                ],
                'Emisor' => $body["Emisor"],
                'Receptor' => $body["Receptor"],
            ],
            'Detalle' => $body["Detalle"],
            'Referencia' => $body["Referencia"],
        ];

        return array("Caratula" => $caratula, "Documento" => $documento);
    };

    return peticion_dte($callback, $req, $res);
};
