# restisy
Base API developed in Laravel

## Commands

- composer install

- php artisan migrate

- php artisan db:seed

- php artisan passport:install




## Request URLs (example)


http://restisy.local/api/register (POST)

```json
Content-Type application/json
{
	"name": "User",
	"email": "user@gmail.com",
	"password": "123456",
	"password_confirmation": "123456"
}
```

http://restisy.local/api/login (POST)

```json
Content-Type application/json
{
	"email": "user@gmail.com",
	"password": "123456"
}
```


http://restisy.local/api/roles (GET)

```json
Content-Type application/json
Authorization Bearer {token}
```

http://restisy.local/api/permissions?page=2 (GET)

```json
Content-Type application/json
Authorization Bearer {token}
```