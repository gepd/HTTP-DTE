<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$boletaEmitir = function (Request $req, Response $res) {
    $callback = function ($body) {
        $caratula = [
            'RutReceptor' => $body["Receptor"]["RUTRecep"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
        ];

        $documento = [
            'Encabezado' => [
                'IdDoc' => [
                    'TipoDTE' => 39,
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
