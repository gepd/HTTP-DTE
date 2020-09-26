<?php

include_once("./helper.php");

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$setBasico = function (Request $req, Response $res) {
    $callback = function ($body) {
        $set = obtener_dato_base64($body["Set"], "UNKNOWN");
        $folios = $body["Folios"];
        $folios_primer = [];
        $folios_data = [];

        foreach ($folios as $key => $value) {
            $folios_primer[$key] = $value["primer"];
            $folios_data[$key]["data"] = $value["data"];
        }

        $emisor = $body["Emisor"];
        $receptor = $body["Receptor"];
        $caratula = [
            'RutReceptor' => $body["Receptor"]["RUTRecep"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
        ];

        $setJson = \sasco\LibreDTE\Sii\Certificacion\SetPruebas::getJSON($set["data"], $folios_primer);
        $setArray = json_decode(json_encode(json_decode($setJson)), true);

        // Agrega Emisor y Receptor a cada documento
        foreach ($setArray as $key => $set) {
            $setArray[$key]["Encabezado"]["Emisor"] = $emisor;
            $setArray[$key]["Encabezado"]["Receptor"] = $receptor;
        }

        return array("Caratula" => $caratula, "Documento" => $setArray, "ListaFolios" => $folios_data);
    };

    return peticion_dte($callback, $req, $res);
};
