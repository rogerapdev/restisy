# restisy
Base API developed in Laravel

## Commands

- composer install

- php artisan migrate

- php artisan db:seed

- php artisan passport:install




## Request URLs (example)

http://restisy.local/api/register (POST)

Content-Type application/json
{
	"name": "User",
	"email": "user@gmail.com",
	"password": "123456",
	"password_confirmation": "123456"
}


http://restisy.local/api/login (POST)

Content-Type application/json
{
	"email": "user@gmail.com",
	"password": "123456"
}



http://restisy.local/api/roles (GET)

Content-Type application/json
Authorization Bearer {token}


http://restisy.local/api/permissions?page=2 (GET)

Content-Type application/json
Authorization Bearer {token}