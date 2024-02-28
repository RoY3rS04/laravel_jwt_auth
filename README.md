<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Simple JWT Auth System

Simple JWT based auth system using laravel.

Please follow the instructions bellow.

1. Clone repository

2. Execute 

```
composer install
```

3. Install JWT package

```
composer require tymon/jwt-auth
```

4. Copy .env.example into .env and replace the variables

5. Follow instructions of the tymon/jwt-aut package <a href="https://jwt-auth.readthedocs.io/en/develop/laravel-installation/">here</a>

6. Do steps 1 and 2 of the following page <a href="https://jwt-auth.readthedocs.io/en/develop/quick-start/">here</a>

7. Run migrations

```
php artisan migrate
```

8. Run server

```
php artisan serve
```

## Used Stack

* Laravel
* MySQL