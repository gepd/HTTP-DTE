<?php

include_once("./helper.php");

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$multiEnvio = function (Request $req, Response $res) {
    $callback = function ($body) {
        $folios = $body["Folios"];
        $folios_data = [];

        foreach ($folios as $key => $value) {
            $folios_data[$key]["data"] = $value["data"];
        }

        $emisor = $body["Emisor"];
        $caratula = [
            'RutReceptor' => $body["RutReceptor"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
        ];

        $documentos = $body["Documentos"];

        // Agrega Emisor y Receptor a cada documento
        foreach ($documentos as $key => $set) {
            $documentos[$key]["Encabezado"]["Emisor"] = $emisor;
        }

        return array("Caratula" => $caratula, "Documento" => $documentos, "ListaFolios" => $folios_data);
    };

    return peticion_dte($callback, $req, $res);
};
