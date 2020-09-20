<?php

$error_type = array(
    "NO_DTE_DATA" => array(
        "name" => "NO_DTE_DATA",
        "message" => "No se pudieron obtener los datos del DTE",
        "statusCode" => 400
    ),
    "FIRMA_NO_BASE64" => array(
        "name" => "FIRMA_NO_BASE64",
        "message" => "La firma debe estar codificada en base64",
        "statusCode" => 400
    ),
    "FOLIOS_NO_BASE64" => array(
        "name" => "FOLIOS_NO_BASE64",
        "message" => "Los folios deben estar codificados en base64",
        "statusCode" => 400
    ),
    "FORMATO_FECHA_RESOL" => array(
        "name" => "FORMATO_FECHA_RESOL",
        "message" => "FchResol debe tener el formato yyyy-mm-dd",
        "statusCode" => 400
    ),
);

function get_error($name)
{
    global $error_type;
    if (array_key_exists($name, $error_type)) {
        return json_encode($error_type[$name]);
    }
    return json_encode(array("DESCONOCIDO" => array(
        "name" => "DESCONOCIDO",
        "message" => "Error desconocido",
        "statusCode" => 400
    ),));
}
