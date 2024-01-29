
**Instructions on how to install the project:**

```
git clone 
copy .env.example and rename .env

docker-composer build
docker-composer up -d
docker-composer exec currency_backend bash

composer install
php bin/console doctrine:migration:migrate
php bin/console doctrine:fixtures:load
```

**Start Tests**

```
 php bin/phpunit
```

**Start Command Task**

```
php bin/console app:check-currency
```
