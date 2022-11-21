##Запуск

Установить docker, composer, php 8

1. `cd корень проекта`
2. `composer i`
3. `vendor/bin/sail up -d`
4. `vendor/bin/sail artisan migrate --seed`
5. в браузере `http://localhost`
6. тестовый пользователь `admin@mail.test` `test`
7. swagger `http://localhost/api/documentation`

