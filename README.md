# ST BARBER

Aplicación web para la gestión de una barbería desarrollada con Laravel 11 y MySQL.

## Stack tecnológico

- PHP 8.2 + Laravel 11
- Bootstrap 5.3 + Blade + JavaScript vanilla
- MySQL
- Railway + Docker

## Funcionalidades principales

- Reserva, modificación y cancelación de citas online
- Comprobación de disponibilidad en tiempo real
- Panel de administración con estadísticas y gestión completa
- Dos roles: cliente y administrador
- Recuperación de contraseña por email

## Instalación en local

Requisitos: PHP 8.2, Composer, Node.js 20, MySQL

```bash
git clone https://github.com/rbastoss01/ST-Barber
cd ST-Barber
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm run build
php artisan serve
```

## Autor

Rodrigo Bastos Sánchez — 2º DAW 2025/2026