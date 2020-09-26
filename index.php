<?php
header("Content-Type: application/json");

include 'inc.php';

include_once('./dte/boleta.php');
include_once('./dte/factura.php');
include_once('./dte/guiadespacho.php');
include_once('./dte/notadecredito.php');
include_once('./dte/libros.php');
include_once('./dte/sets.php');
include_once('./dte/multienvio.php');

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);
$app->addBodyParsingMiddleware();

$app->group("/dte", function (RouteCollectorProxy $group) {
    global $dteEstado;
    global $boletaEmitir;
    global $facturaEmitir;
    global $facturaEmitirExenta;
    global $guiaDespachoEmitir;
    global $notaDeCredito;
    global $notaDeDebito;
    global $libroGuiaDespacho;
    global $libroCompraVenta;
    global $setBasico;
    global $multiEnvio;

    $group->post("/estado", $dteEstado);
    $group->post("/boleta/emitir", $boletaEmitir);
    $group->post("/factura/emitir", $facturaEmitir);
    $group->post("/factura/exenta/emitir", $facturaEmitirExenta);
    $group->post("/guiadespacho/emitir", $guiaDespachoEmitir);

    $group->post("/notadecredito", $notaDeCredito);
    $group->post("/notadedebito", $notaDeDebito);

    $group->post("/libroguiadedespacho", $libroGuiaDespacho);
    $group->post("/librocompraventa", $libroCompraVenta);

    $group->post("/setbasico", $setBasico);
    $group->post("/multiEnvio", $multiEnvio);
});

$app->run();
