# Test Robots.txt

## Requirements

- php [7.1]
- Laravel [5.6]

## Installation

After download run composer and npm install:
```sh
composer install
npm install
```

##### Rename .env.example to .env

Generate APP_KEY by running the command
```sh
php artisan key:generate
```

##### Add permissions for directories storage and bootstrap/cache:
```sh
sudo chmod 777 -R storage/
sudo chmod 777 -R bootstrap/cache
```

For speed:
```sh
npm run prod
php artisan route:cache
```

## Configuration


## Usage
Run server:
```sh
php artisan serve
```
and go to: "http://127.0.0.1:8000/"
