const http = require('http');
const express = require('express');

const app = express();
// PUERTO QUE USARÁ EXPRESS
const port = 3000;

// OPCIONES DEL MODULO HTTP PARA REALIZAR LA LLAMADA
const options = {
    hostname: 'dte-api',
    port: 8000,
    path: '/dte/estado',
    method: 'POST'
}

app.get('/', (req, res) => {
    // LLAMADA A HTTP-DTE
    const apiReq = http.request(options, apiRes => {
        let str = '';

        apiRes.on('data', data => str += data);
      
        apiRes.on('end', function () {
          res.send(str);
          // SI RECIBES EL ERROR:
          // {
          // "name":"FIRMA_NO_BASE64",
          // "message":"La firma debe estar codificada en base64",
          // "statusCode":400
          // }
          // ES PORQUE AMBOS CONTAINERS SE HAN COMUNICADO CORRECTAMETNE
        });
    });

    apiReq.end();
});

app.listen(port, () => {
    console.log(`Servidor nodejs escuchando en: http://localhost:${port}`)
});