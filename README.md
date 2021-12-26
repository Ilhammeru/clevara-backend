<p align="center">Panduan Install</p>

## Clevara backend

run

```
composer install
composer update
```

change env

```

cp .env.example .env
```

change some configuration in Mail section, This configuration is required when checking out is done
When checkout is done, system will send some summary order to your email

migrate database and seeder (Using Postgre)

```
php artisan migrate --seed
```

