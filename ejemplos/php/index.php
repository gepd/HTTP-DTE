<?php

$url = 'http://dte-api:8000/dte/estado';
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

echo  $server_output;
// SI RECIBES EL ERROR:
// {
// "name":"FIRMA_NO_BASE64",
// "message":"La firma debe estar codificada en base64",
// "statusCode":400
// }
// ES PORQUE AMBOS CONTAINERS SE HAN COMUNICADO CORRECTAMETNE