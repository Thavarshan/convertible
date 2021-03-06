[![Convertible](https://raw.githubusercontent.com/Thavarshan/convertible/main/.github/banner.svg)](https://github.com/Thavarshan/convertible)

# Convertible

## Introduction

Convertible is an online audio file converter. Currently we only support `.mp3` files but we will be expanding our list pretty soon so hold tight! Convertible uses **CloudConvert** to convert and process files.

## Installation

Please check the official **Laravel** installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)

Clone the repository

```bash
git clone https://github.com/Thavarshan/convertible.git
```

Switch to the repo folder

```bash
cd convertible
```

Install all the dependencies using composer

```bash
composer install
```

Copy the example env file and make the required configuration changes in the .env file

```bash
cp .env.example .env
```

Generate a new application key

```bash
php artisan key:generate
```

Run the database migrations (**Set the database connection in .env before migrating**)

```bash
php artisan migrate
```

Start the local development server

```bash
php artisan serve
```

You can now access the server at http://localhost:8000

**TL;DR command list**

```bash
git clone https://github.com/Thavarshan/convertible.git
cd convertible
composer install
cp .env.example .env
php artisan key:generate
```

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

```bash
php artisan migrate
php artisan serve
```

## Security Vulnerabilities

Please review [our security policy](https://github.com/thavarhan/convertible/security/policy) on how to report security vulnerabilities.

## License

Convertible is open-sourced software licensed under the [MIT license](LICENSE).
