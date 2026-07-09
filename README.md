# Proyecto Laravel con Livewire y Greender

Este es un proyecto de ejemplo que utiliza Laravel como framework de backend, Livewire para la interacción en tiempo real y Greender para la gestión de datos de facturación electrónica.

## Requisitos Previos

Asegúrate de tener instalado lo siguiente en tu máquina:

- PHP >= 8.2
- Composer (última versión estable)
- Node.js >= 18.x y npm >= 9.x
- Un servidor de base de datos (MySQL >= 8.2 o PostgreSQL >= 14)
- Git
- Extensión PHP para tu base de datos (pdo_mysql o pdo_pgsql)
- Extensión PHP para XML
- Extensión PHP para cURL
- Extensión PHP para ZIP

## Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

### 1. Clonar el Repositorio

```bash
git clone https://github.com/abitae/transportes.git
cd transportes
```

### 2. Instalar Dependencias PHP

```bash
composer install
```

### 3. Configurar Variables de Entorno

Copia el archivo `.env.example` a `.env` y configura las variables necesarias:

```bash
cp .env.example .env
```

Edita el archivo `.env` con tus credenciales de base de datos y otras configuraciones:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=transportes
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 4. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 5. Ejecutar Migraciones

```bash
php artisan migrate --seed
```

### 6. Instalar Dependencias JavaScript

```bash
npm install
```

### 7. Compilar Assets

```bash
npm run dev
```

### 8. Iniciar el Servidor de Desarrollo

```bash
php artisan serve
```

El proyecto estará disponible en `http://localhost:8000`

## Estructura del Proyecto

- `app/` - Contiene la lógica principal de la aplicación
- `resources/` - Contiene vistas, assets y componentes Livewire
- `database/` - Migraciones y seeders
- `config/` - Archivos de configuración
- `routes/` - Definición de rutas
- `public/` - Archivos públicos y assets compilados

## Comandos Útiles

- `php artisan migrate:fresh` - Reiniciar la base de datos
- `php artisan db:seed` - Ejecutar seeders
- `php artisan optimize:clear` - Limpiar caché
- `npm run build` - Compilar assets para producción

## Soporte

Si encuentras algún problema o tienes preguntas, por favor abre un issue en el repositorio.