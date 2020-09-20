<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$notaDeDebito = function (Request $req, Response $res) {
    $callback = function ($body) {
        $caratula = [
            'RutReceptor' => $body["Receptor"]["RUTRecep"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
        ];

        $documento = [
            'Encabezado' => [
                'IdDoc' => [
                    'TipoDTE' => 56,
                    'Folio' => $body["Folio"],
                ],
                'Emisor' => $body["Emisor"],
                'Receptor' => $body["Receptor"],
                'Totales' => [
                    'MntNeto' => 0,
                    'MntExe' => 0,
                    'TasaIVA' => \sasco\LibreDTE\Sii::getIVA(),
                    'IVA' => 0,
                    'MntTotal' => 0,
                ],
            ],
            'Detalle' => $body["Detalle"],
            'Referencia' => $body["Referencia"]
        ];

        return array("Caratula" => $caratula, "Documento" => $documento);
    };

    return peticion_dte($callback, $req, $res, true);
};
