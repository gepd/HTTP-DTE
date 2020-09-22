<?php
header("Content-Type: application/json");

include 'inc.php';

include_once('./dte/factura.php');
include_once('./dte/notadecredito.php');
include_once('./dte/libros.php');

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

$app = AppFactory::create();

$app->addErrorMiddleware(true, false, false);
$app->addBodyParsingMiddleware();

$app->group("/dte", function (RouteCollectorProxy $group) {
    global $dteEstado;
    global $facturaEmitir;
    global $facturaEmitirExenta;
    global $notaDeCredito;
    global $notaDeDebito;
    global $libroGuiaDespacho;

    $group->post("/estado", $dteEstado);
    $group->post("/factura/emitir", $facturaEmitir);
    $group->post("/factura/exenta/emitir", $facturaEmitirExenta);

    $group->post("/notadecredito", $notaDeCredito);
    $group->post("/notadedebito", $notaDeDebito);

    $group->post("/libroguiadedespacho", $libroGuiaDespacho);
});

$app->run();
