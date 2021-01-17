# Notas academica

### Pre-requisitos 📋

- PHP >= 7.4 
- sqlite 3
- mysql
- Composer versión 2. 
- Extensión pdo_sqlite habilitada.
- Extensión soap habilitada.
- node >= 14.15
- npm

### Instalación 🔧

1. Clonar el repositorio en el directorio del servidor web

2. Instalar paquetes de composer ejecutando `composer install`.

3. Instalar paquetes de node `npm install && npm run prod`

4. Copiar el archivo `.env.example` incluido en uno de nombre `.env` y completar variables de conexión a base de datos mysql

5. ejecutar comando `php artisan migrate:fresh --seed` 

6. Ejecutar pruebas `php artisan test`

7. Acceder al sitio.

------------------------