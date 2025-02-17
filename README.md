<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Documentación Técnica: Sistema de Gestión de Cócteles
## ÍNDICE

 1. Descripción General
 2. Requerimientos del Sistema
 3. Instalación y Configuración
 4. Estructura del Proyecto
 5. Variables de Entorno
 6. Uso de Git y Subida a GitHub
 7. Manejo de la API (TheCocktailDB)
 8. Solución al Error cURL 60: SSL certificate problem
 9. Despliegue (Deployment)
 10. Contacto y Créditos

## Descripción General
Este proyecto es un **Sistema de Gestión de Cócteles** desarrollado en **Laravel** (versión 9+), que permite:
-   **Autenticación** de usuarios (registro, login, logout).
-   **Consumo** de la API pública [TheCocktailDB](https://www.thecocktaildb.com/) para listar cócteles.
-   **Búsqueda** de cócteles por nombre, categoría o tipo.
-   **Favoritos**: almacenar cócteles marcados como favoritos en la base de datos.
-   **Sección de Perfil** para actualizar datos del usuario y la contraseña.
-   **Diseño** responsivo y profesional con **Bootstrap 5**, íconos de **Bootstrap Icons**, y animaciones/hover.


## Requerimientos del Sistema

   - **PHP** >= 8.0
-   **Composer** >= 2.0
-   **MySQL** (o MariaDB) para la base de datos.
-   **Node.js** >= 14 y **npm** >= 6 para compilar assets con Vite (opcional, si usas Laravel Mix / Vite).
-   **Extensiones de PHP**: `openssl`, `pdo`, `mbstring`, `curl`, etc.

## Instalación y Configuración
**1. **Clonar** el repositorio:**
 `git clone https://github.com/MaickR/MiCocktailApp.git
cd cocktail-manager
`

**2. **Instalar** dependencias de Laravel:**

    composer install

**3. **Instalar** dependencias de Node (para Vite/Mix):**

    npm install

**4**. **Copiar** **el archivo de ejemplo de entorno:**

    cp .env.example .env

**5**. ****Generar** la key de la aplicación:**

    php artisan key:generate

**6**. **Configurar** la base de datos en `.env`:

   

     DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=cocktail_db
    DB_USERNAME=root
    DB_PASSWORD=root

**7**. ****Ejecutar** las migraciones y seeders (opcional):**

    php artisan migrate --seed

**8**. **Compilar los assets con Vite en modo desarrollo:**

    npm run dev

**9**. ****Levantar** el servidor local de Laravel:**

    php artisan serve
    Accede a [http://127.0.0.1:8000](http://127.0.0.1:8000).


## Estructura del Proyecto
-   El proyecto sigue la **convención** de Laravel:

    cocktail-manager/
    ├─ app/                # Controladores, Modelos, etc.
    ├─ config/             # Archivos de configuración
    ├─ database/
    │  ├─ migrations/      # Migraciones de BD
    │  └─ seeders/         # Seeders de BD
    ├─ public/             # Carpeta pública (index.php)
    ├─ resources/
    │  ├─ css/             # Archivos CSS (app.css si usas Vite)
    │  ├─ js/              # Archivos JS (app.js si usas Vite)
    │  └─ views/           # Vistas Blade (layouts, home, search, etc.)
    ├─ routes/
    │  └─ web.php          # Rutas de la aplicación
    ├─ vite.config.js      # Configuración de Vite
    ├─ package.json        # Dependencias de Node
    ├─ composer.json       # Dependencias de PHP
    └─ .env                # Variables de entorno


## Variables de Entorno
En el archivo `.env`:
-   **APP_NAME**: Nombre de la aplicación.
-   **APP_ENV**: `local` o `production`.
-   **APP_URL**: URL base (por defecto `http://127.0.0.1:8000`).
-   **DB_DATABASE**, **DB_USERNAME**, **DB_PASSWORD**: Configuración de la base de datos.
-   **API Keys** (si tuvieras): Se manejan en `.env` para no exponerlas.


## Uso de Git y Subida a GitHub


 1. **Crear** un repositorio en GitHub (público o privado).
 2.   **Agregar** el remoto

     git remote add origin https://github.com/MaickR/MiCocktailApp.git
    
 3.  **Commit** y push inicial:

   

     git add .
    git commit -m "Initial commit"
    git push -u origin main


## Manejo de la API (TheCocktailDB)
El proyecto consume la **API pública** de TheCocktailDB.

-   Se usa **Http** de Laravel con `Http::get(...)`.
-   Ejemplo de endpoint:

    $response = Http::get('https://www.thecocktaildb.com/api/json/v1/1/search.php?s=margarita');
    
    Los datos se **mapean** en controladores (ej. `CocktailController`) y se muestran en vistas (`home.blade.php`, `search.blade.php`).


## Solución al Error cURL 60: SSL certificate problem
Si surge el error:

    cURL error 60: SSL certificate problem: unable to get local issuer certificate

al obtener datos de la API, hay dos opciones:

1.  **Modificar** el archivo `php.ini`: 1.1. Abrir `php.ini` (por ejemplo, en `C:\php\php.ini`).  
    1.2. Buscar las secciones `[curl]` y `[openssl]`.  
    1.3. Descargar [cacert.pem](http://curl.haxx.se/ca/cacert.pem) y guardarlo en la carpeta donde está `php.ini`.  
    1.4. En `[curl]` agregar: `ini curl.cainfo="C:\php\cacert.pem"` 1.5. En `[openssl]` agregar: `ini openssl.cafile="C:\php\cacert.pem"` 1.6. **Reiniciar** el servidor.  
    Problema resuelto.
    
2.  **Desactivar** la verificación SSL temporalmente (no recomendado en producción), por ejemplo:

    Http::withOptions(['verify' => false])->get('https://www.thecocktaildb.com/...');


## Despliegue (Deployment)
-   **Subir** el código a tu servidor (por ejemplo, un VPS, Heroku, etc.).
-   **Ejecutar** `composer install --optimize-autoloader --no-dev`.
-   **Configurar** las variables de entorno (`.env`) con los datos de producción (BD, etc.).
-   **Migrar** la BD: `php artisan migrate --force`.
-   **Compilar** assets con `npm run build` (para Vite) o subirlos ya compilados.
-   **Configurar** tu servidor web (Nginx, Apache) para que apunte a la carpeta `public/`.
-   **Probar** la aplicación en el dominio final.

#  Contacto y Créditos

-   **Autor**: <Mike_Dev/>
-   **Repositorio**: [\[MikeR\]](https://github.com/MaickR)
-   **Licencia**: MIT

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
