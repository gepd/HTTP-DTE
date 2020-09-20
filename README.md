# HTTP DTE

> ⚠⚠⚠ ESTE PROYECTO ESTÁ EN DESARROLLO, NO DEBE SER USADO EN PRODUCCIÓN

Este es un experimento en progreso que usa la librería PHP de [LibreDTE](https://github.com/LibreDTE/libredte-lib) para generar una API HTTP. Con esta API podrás generar documentos y enviarlos al Servicio de Impuestos Internos de Chile.

La implementación de esta API está realizada con docker y docker-compose y slim, esto permite integrar la API con cualquier lenguage. La API no administra ningún estado, en cada petición será necesario enviar valores como la firma y los folios entre otros parámetros, Por lo mismo es responsabilidad del consumer implementar un sistema de autenticación. El uso de docker-composer permite generar una red interna donde un segundo backend puede realizar peticiones HTTP a esta API, este segundo backend será el encargado de administrar todo lo relacionado a los DTEs

Esquema con ejemplo de como usar la librería

![Esquema]("https://github.com/gepd/HTTP-DTE/blob/develop/images/esquema.jpg")

### Requisitos

Para Probar la librería necesitas

- [Docker](https://www.docker.com/products/docker-desktop)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Instalación

#### Desarrollo

La estalación es muy simple, solo clona este reprositorio y ejecuta el siguiente comando (por ahora solo para desarrollo)

`docker-compose up -f ./docker-compose.dev.yml`

Esto instalará todas las dependencias automáticamente y quedará listo para usar 🚀

_NOTA: No es necesario reiniciar el contenedor al realizar un cambio en la librería, estos serán reconocidos automáticamente_

### Peticiones

Realiza una petición con cualquier cliente, como por ejemplo Postman

[Lista de endpoints disponibles]("https://github.com/gepd/HTTP-DTE/blob/develop/ENDPOINTS.md") 🔥

El archivo `docker-compose.yml` contiene un ejemplo de como comunicar el container de HTTP DTE y el que vayas a usar como backend

### Lista de Tareas

- [x] Envío de Facturas
- [x] Envío de Facturas Exentas
- [x] Envío de Nota de Crédito
- [x] Envío de Nota de Débito
- [ ] Envío de Guía de Despacho
- [ ] Envío de Libro de Compras
- [ ] Envío de Libro de Ventas
- [ ] Envío de Boleta Electrónica
- [ ] Leer estado de DTE
- [ ] Lista de Contribuyentes Autorizados
- [ ] Enviar Multiples DTEs
- [ ] Enviar Set de Pruebas
- [ ] Selección de Formato de Hoja en PDF
- [ ] Mejorar manejo de errores

### Contribuciones

Cualquier PR es bienvenido y si tienes algún problema no dudes en abrir un issue para poder resolverlo.

### LICENCIA

Este proyecto está liberado bajo la licencia MIT, quiere decir que puedes hacer lo que quieras (incluso comercialmente). Sin embargo [LibreDTE](https://github.com/LibreDTE/libredte-lib) tiene su propia licencia, verifica esto en su repositorio.
