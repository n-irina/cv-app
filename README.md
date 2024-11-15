<p align="center"><img src="/storage/media/logo.png" width="100" alt="logo cv-app"></p>

## About cv-app

cv-app is a backoffice application that allows users to upload their resume and keep a traceability of sending to companies

## Contents

- [Project installation](#Project-installation)
    - [Requirements](#Requirements)
    - [Cloning the project](#Cloning-the-project)
    - [Livewire installation](#livewire-installation)
    - [Filament installation](#filament-installation)
- [Dependencies installation](#Dependencies-installation)
    - [Panel builder package](#panel-builder-package)
    - [Table builder package](#table-builder-package)
    - [Tailwind CSS](#tailwind-css)
    - [domPDF package](#domPdf-package)
    - [Pdf to image package](#pdf-to-image-package)
    - [Database configuration](#database-configuration)
    - [Running the database](#running-the-database)
- [How to run the server](#how-to-run-the-server) 
    - [Front server](#front-server)
    - [Back server](#back-server)

## Project installation

### Requirements

- PHP 8.1 +
- Laravel v10.0 +
- Livewire v3.0 +

### Cloning the project

```bash
  git clone git@github.com:n-irina/cv-app.git
```
### Laravel installation

```bash
  composer install
```
### Livewire installation

```bash
  composer require livewire/livewire
```
### Filament installation
```bash
  composer require filament/filament:"^3.2" -W
```
## Dependencies installation

### Panel builder package

```bash
  php artisan filament:install --panels
```
### Table builder package

```bash
  composer require filament/tables:"^3.2" -W
  php artisan filament:install --tables
```
### Tailwind CSS

```bash
  npm install tailwindcss @tailwindcss/forms @tailwindcss/typography postcss postcss-nesting autoprefixer --save-dev
```
### DomPDF package

If you'd like to be abble to download a PDF file you can download domPdf package into your project just run those lines:
```bash
  composer require barryvdh/laravel-dompdf
  php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```
You now have to add those arrays into your config/app.php

```php
'providers' => [

	// Service Provider DomPDF
	Barryvdh\DomPDF\ServiceProvider::class

],

'aliases' => Facade::defaultAliases()->merge([

	// Façade Laravel-dompdf
	"PDF" => Barryvdh\DomPDF\Facade::class

])->toArray(),
```
### Pdf to image package

If you want to make previews of pdf you have to install this package:

```bash
  composer require drenso/pdf-to-image
```
And to have an image of your pdf in your views add this one:

```bash
  composer require joapaulolndev/filament-pdf-viewer
```

### Tags package

```bash
  composer require filament/spatie-laravel-tags-plugin:"^3.2" -W
```

### Database configuration

To configure your database, go to the .env, uncomment the specific lines and change the information.
```.php
DB_CONNECTION=your_db_app
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_login_user
DB_PASSWORD=your_password
```
### Running the database

#### Run migrations

```bash
  php artisan migrate
```
#### Run the seeders

```bash
  php artisan db:seed
```

## How to run the server

If your app is running on your localhost click on the link below after running those lines:  
http://localhost:8000

### Front server

```bash
  npm run dev
```
### Back server

```bash
  php artisan serve
```
