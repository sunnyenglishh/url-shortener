# URL Shortener

A Laravel-based URL Shortener with role-based access control and company management.

## Features

- SuperAdmin, Admin and Member roles
- Company management
- User invitation and registration
- Short URL generation
- Public URL redirection
- Role-based URL access
- Feature and Unit tests

## Tech Stack

- Laravel
- PHP
- MySQL
- Blade
- Tailwind CSS
- PHPUnit

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Configure database and mail settings in `.env`.

## Testing

```bash
php artisan test
```

Tests cover URL creation, role restrictions, company-level access, member-level access and public URL redirection.


## AI Usage

I used ChatGPT mainly for syntax reference, debugging, and understanding Laravel concepts.

- Used ChatGPT for Blade and HTML syntax.
- Used ChatGPT to understand and write Laravel Unit and Feature tests.
- Used ChatGPT for Laravel syntax and debugging issues.
- Used ChatGPT for Git commit message suggestions.
- Used ChatGPT to prepare the README file.
