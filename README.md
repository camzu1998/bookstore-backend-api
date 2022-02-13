## Bookstore Backend API

Bookstore backend API is a web backend application.

## Requirements
- Docker
- Composer
- Git
## Installation

git clone https://github.com/camzu1998/bookstore-backend-api.git

composer update

### Docker preparation

composer require laravel/sail --dev

php artisan sail:install (choose mysql)

./vendor/bin/sail up

### Prepare database:

php artisan migrate

### To get prepared data enter:

php artisan db:seed
