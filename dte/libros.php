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

    return peticion_libro_guia($callback, $req, $res);
};

$libroCompraVenta = function (Request $req, Response $res) {
    $callback = function ($body) {
        $caratula = [
            'RutEmisorLibro' => $body["RutEmisorLibro"],
            'RutEnvia' => $body["RutEnvia"],
            'PeriodoTributario' => $body["PeriodoTributario"],
            'FchResol' => $body["FchResol"],
            'NroResol' => $body["NroResol"],
            'TipoOperacion' => $body["TipoOperacion"],
            'TipoLibro' => $body["TipoLibro"],
            'TipoEnvio' => $body["TipoEnvio"],
            'FolioNotificacion' => $body["FolioNotificacion"],
        ];

        return array("Caratula" => $caratula, "Libro" => $body["Libro"]);
    };

    return peticion_libro_compra_venta($callback, $req, $res);
};
