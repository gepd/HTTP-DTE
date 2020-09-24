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

#### Delimitador CSV

En los casos como los libros de compra y venta en que se envía el libro en formato CSV se puede usar la varible
`csv_delimitador` para definir el delimitador del archivo.

por defecto: `csv_delimitador=;`

Ejemplo

`/dte/factura?csv_delimitador=,`

### Boleta Electrónica

1. POST `/dte/boleta/emitir`

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

### Factura Electrónica

2. POST `/dte/factura/emitir`

Devuelve JSON con TrackId

3. POST `/dte/factura/exenta/emitir`

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

4. POST `/dte/notadecredito`

Devuelve JSON con TrackId

5. POST `/dte/notadedebito`

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

### Estado de un documento

6. POST `/dte/estado`

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```json
{
  "rut": "",
  "trackId": "",
  "Firma": {
    "data": "", // Firma codificada en base64
    "pass": ""
  }
}
```

### Libro de Guías de Despacho

7. POST `/dte/libroguiadedespacho`

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```json
{
  "Firma": {
    "data": "", // Firma codificada en base64
    "pass": ""
  },
  "RutEmisorLibro": "",
  "FchResol": "",
  "NroResol": 0,
  "FolioNotificacion": 0,
  "Detalle": [
    {
      "Folio": 0,
      "TpoOper": 0,
      "RUTDoc": ""
    }
  ]
}
```

### Libro de Compra y Venta

8. POST `/dte/librocompraventa`

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```json
{
  "Firma": {
    "data": "", // firma en base64
    "pass": ""
  },
  "RutEmisorLibro": "",
  "RutEnvia": "",
  "PeriodoTributario": "",
  "TipoOperacion": "",
  "TipoLibro": "",
  "TipoEnvio": "",
  "FchResol": "",
  "NroResol": 0,
  "FolioNotificacion": 0,
  "Libro": "" // Libro codificado en base64
}
```
