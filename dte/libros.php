<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$libroGuiaDespacho = function (Request $req, Response $res) {
    $callback = function ($body) {
        $caratula = [
            'RutEmisorLibro' => $body["RutEmisorLibro"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
            'FolioNotificacion' => $body["FolioNotificacion"],
        ];

        $documento = [
            'Detalle' => $body["Detalle"]
        ];

        return array("Caratula" => $caratula, "Documento" => $documento);
    };

    return peticion_libro($callback, $req, $res);
}