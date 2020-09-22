## Lista de Endpoints disponibles

### Opciones

#### Certificación

Para trabajar con el ambiente de certificación agregar `?certificacion=1` a la petición

Ejemplo:

`/dte/factura?certificacion=1`

#### Previsualización

Antes de enviar un documento al SII es posible previsualizarla utilizando el parámetro `previsualizacion=1`

Ejemplo:

`/dte/factura?previsualizar=1`

#### Posición del logo

El logo en los archivos PDF puede tener dos posiciones; izquierda (1) y arriba (0), por defecto está a la izquierda, establecer la variable `logo_izquierda=0` para cambiar la posición.

Ejemplo

`/dte/factura?logo_izquierda=0`

### Factura Electrónica

1. POST `/dte/factura/emitir`

Devuelve JSON con TrackId

2. POST `/dte/factura/exenta/emitir`

Devuelve JSON con TrackId

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```json
{
  "LogoUrl": "", // URL a imagen PNG
  "Firma": {
    "data": "", // firma codificada en base64
    "pass": ""
  },
  "FchResol": "yyyy-mm-dd",
  "NroResol": 0,
  "Folios": {
    "data": "" // folios codificados en base64
  },
  "Folio": 0,
  "Emisor": {
    "RUTEmisor": "",
    "RznSoc": "",
    "GiroEmis": "",
    "Acteco": 0,
    "DirOrigen": "",
    "CmnaOrigen": ""
  },
  "Receptor": {
    "RUTRecep": "",
    "RznSocRecep": "",
    "GiroRecep": "",
    "DirRecep": "",
    "CmnaRecep": ""
  },
  "Detalle": [
    {
      "NmbItem": "",
      "QtyItem": 0,
      "PrcItem": 0
    }
  ]
}
```

### Nota de Crédito / Débito

3. POST `/dte/notadecredito`

Devuelve JSON con TrackId

4. POST `/dte/notadedebito`

Devuelve JSON con TrackId

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```json
{
  "LogoUrl": "", // URL a imagen PNG
  "Firma": {
    "data": "", // firma codificada en base64
    "pass": ""
  },
  "FchResol": "yyy-mm-dd",
  "NroResol": 0,
  "Folios": {
    "data": "" // folios codificados en base64
  },
  "Folio": 0,
  "Emisor": {
    "RUTEmisor": "",
    "RznSoc": "",
    "GiroEmis": "",
    "Acteco": 0,
    "DirOrigen": "",
    "CmnaOrigen": ""
  },
  "Receptor": {
    "RUTRecep": "",
    "RznSocRecep": "",
    "GiroRecep": "",
    "DirRecep": "",
    "CmnaRecep": ""
  },
  "Detalle": [
    {
      "NmbItem": "ITEM AFECTO",
      "QtyItem": 0,
      "PrcItem": 0
    },
    {
      "IndExe": 1,
      "NmbItem": "ITEM EXENTO",
      "QtyItem": 0,
      "PrcItem": 0
    }
  ],
  "Referencia": [
    {
      "TpoDocRef": "",
      "FolioRef": 0,
      "RazonRef": ""
    },
    {
      "TpoDocRef": 0,
      "FolioRef": 0,
      "CodRef": 0,
      "RazonRef": ""
    }
  ]
}
```