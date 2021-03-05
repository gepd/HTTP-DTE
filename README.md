# HTTP DTE

> ⚠⚠⚠ ESTE PROYECTO ESTÁ EN DESARROLLO, NO DEBE SER USADO EN PRODUCCIÓN

Este es un experimento en progreso que usa la librería PHP de [LibreDTE](https://github.com/LibreDTE/libredte-lib) para generar una API HTTP. Con esta API podrás generar documentos y enviarlos al Servicio de Impuestos Internos de Chile.

La implementación de esta API está realizada con docker y docker-compose y slim, esto permite integrar la API con cualquier lenguage. La API no administra ningún estado, en cada petición será necesario enviar valores como la firma y los folios entre otros parámetros, Por lo mismo es responsabilidad del consumer implementar un sistema de autenticación. El uso de docker-composer permite generar una red interna donde un segundo backend puede realizar peticiones HTTP a esta API, este segundo backend será el encargado de administrar todo lo relacionado a los DTEs

Esquema con ejemplo de como usar la librería

![Esquema](https://github.com/gepd/HTTP-DTE/blob/develop/images/esquema.jpg?raw=true)

### Requisitos

Para Probar la librería necesitas

- [Docker](https://www.docker.com/products/docker-desktop)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Instalación

#### Desarrollo

##### API

Si deseas hacer llamadas directamente a la API ejecuta:

`docker-compose up -f ./docker-compose.api.yml`

Esto instalará todas las dependencias automáticamente y quedará listo para usar 🚀

Puedes acceder a la api desde: `http://localhost:8000`

_NOTA: No es necesario reiniciar el contenedor al realizar un cambio en la librería, estos serán reconocidos automáticamente_

##### Llamada entre contenedores

El archivo `docker-compose.yml` contiene ejemplos con diferentes lenguajes para utilizar HTTP-DTE

Para instalar las dependencias de NodeJS primero hay que ejecutar:

`sudo docker-compose -f ejemplos/node/docker-compose.builder.yml run --rm install`

> Si no te interesa NodeJS comenta el servicio `app-node` en `docker-compose-yml` y no ejecutes el comando anterior)

Finalmente ejecuta

`docker-compose up`

Este útimo comando ejecutará todos los ejemplos disponibles

* Abrir `http://localhost:3000` para ver el ejemplo de NodeJS
* Abrir `http://localhost:3001` para ver el ejemplo de PHP

### Peticiones

[Lista de endpoints disponibles](https://github.com/gepd/HTTP-DTE/blob/develop/ENDPOINTS.md) 🔥

El archivo `docker-compose.yml` contiene un ejemplo de como comunicar el container de HTTP DTE y el que vayas a usar como backend

### Lista de Tareas

- [x] Envío de Facturas (33)
- [x] Envío de Facturas Exentas (34)
- [x] Envío de Nota de Crédito (61)
- [x] Envío de Nota de Débito (56)
- [x] Guía de Despacho (52)
- [x] Envío Libro de Guías de Despacho
- [x] Envío de Libro de Compras
- [x] Envío de Libro de Ventas
- [x] Envío de Boleta Electrónica (39)
- [x] Leer estado de DTE
- [x] Enviar Set de Pruebas Básico
- [x] Enviar Multiples DTEs
- [x] Selección de Formato de Hoja en PDF
- [ ] Lista de Contribuyentes Autorizados
- [ ] Mejorar manejo de errores

### Contribuciones

Cualquier PR es bienvenido y si tienes algún problema no dudes en abrir un issue para poder resolverlo.

### LICENCIA

Este proyecto está liberado bajo la licencia MIT, quiere decir que puedes hacer lo que quieras (incluso comercialmente). Sin embargo [LibreDTE](https://github.com/LibreDTE/libredte-lib) tiene su propia licencia, verifica esto en su repositorio.
