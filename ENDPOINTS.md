## Lista de Endpoints disponibles

### Opciones

#### Certificación

Para trabajar con el ambiente de certificación agregar `?certificacion=1` a la petición

Ejemplo:

`/dte/factura?certificacion=1`

_por defecto: `certificacion=0`_

#### Previsualización

Antes de enviar un documento al SII es posible previsualizarla utilizando el parámetro `previsualizacion=1`

Ejemplo:

`/dte/factura?previsualizar=1`

_por defecto: `previsualizar=0`_

#### Posición del logo

El logo en los archivos PDF puede tener dos posiciones; izquierda (1) y arriba (0), por defecto está a la izquierda, establecer la variable `logo_izquierda=0` para cambiar la posición.

Ejemplo

`/dte/factura?logo_izquierda=0`

_por defecto: `logo_izquierda=1`_

#### Papel Continuo

Al general un documento es posible definir el tipo de papel en el cual se va a imprimir, los posibles valores son:

- 0: Hoja carta
- 57: Papel contínuo 57mm
- 75: Papel contínuo 75mm
- 80: Papel contínuo 80mm
- 110: Papel contínuo 110mm

Ejemplo

`/dte/factura?papel_continuo=57`

_por defecto: `papel_continuo=0`_

#### Delimitador CSV

En los casos como los libros de compra y venta en que se envía el libro en formato CSV se puede usar la varible
`csv_delimitador` para definir el delimitador del archivo.

_por defecto: `csv_delimitador=;`_

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

```jsonc
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

```jsonc
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

```jsonc
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

### Guía de Despacho

6. POST `/dte/guiadespacho/emitir`

Devuelve JSON con TrackId

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```jsonc
{
  "LogoUrl": "", // URL a imagen PNG
  "Firma": {
    "data": "", // Firma codificada en base64
    "pass": ""
  },
  "Folios": {
    "data": "" // Folios codificados en base64
  },
  "FchResol": "",
  "NroResol": 0,
  "Folio": 0,
  "TipoDespacho": 0,
  "IndTraslado": 0,
  "Detalle": [
    {
      "NmbItem": "",
      "QtyItem": ""
    }
  ],
  "Referencia": [
    {
      "TpoDocRef": "",
      "FolioRef": 0,
      "RazonRef": ""
    }
  ],
  "Emisor": {
    "RUTEmisor": "",
    "RznSoc": "",
    "GiroEmis": "",
    "Acteco": 0,
    "CorreoEmisor": ""
  },
  "Receptor": {
    "RUTRecep": "",
    "RznSocRecep": "",
    "DirRecep": "",
    "CmnaRecep": ""
  }
}
```

### Estado de un documento

7. POST `/dte/estado`

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```jsonc
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

8. POST `/dte/libroguiadedespacho`

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```jsonc
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

### Set Básico de Pruebas

10. POST `/dte/setbasico`

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```jsonc
{
  "Firma": {
    "data": "", // Firma codificada en base64
    "pass": ""
  },
  "Folios": {
    // Tipo de DTE (ej. 33)
    "": {
      "primer": 0, // Primer folio disponible para usar
      "data": "" // Folios codificados en base64
    }
  },
  "Set": {
    "data": "" // Set básico codificado en base64
  },
  "FchResol": "",
  "NroResol": 0,
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
  }
}
```

### Multi Envío de DTEs

10. POST `/dte/multiEnvio`

#### Cabecera

```
Content-Type: application/json
```

#### Cuerpo

```jsonc
{
  "Firma": {
    "data": "", // Firma codificada en base64
    "pass": ""
  },
  "Folios": {
    // Tipo de DTE (ej. 33)
    "": {
      "data": "" // Folios codificados en base64
    }
  },
  "Documentos": [
    {
      "Encabezado": {
        "IdDoc": {
          "TipoDTE": 0,
          "Folio": 0
        },
        "Receptor": {
          "RUTRecep": "",
          "RznSocRecep": "",
          "GiroRecep": "",
          "DirRecep": "",
          "CmnaRecep": ""
        }
      },
      "Detalle": [
        {
          "NmbItem": "",
          "QtyItem": 0,
          "PrcItem": 0
        }
      ]
    }
  ],
  "RutReceptor": "",
  "FchResol": "",
  "NroResol": 0,
  "Emisor": {
    "RUTEmisor": "",
    "RznSoc": "",
    "GiroEmis": "",
    "Acteco": 0,
    "DirOrigen": "",
    "CmnaOrigen": ""
  }
}
```
