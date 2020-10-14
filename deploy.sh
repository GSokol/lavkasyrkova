#!/bin/bash

# перевести в maintance
# php artisan down
# очистить закешированные файлы
rm -f bootstrap/cache/*.php
composer dump-autoload
php artisan config:clear
php artisan route:clear
php artisan cache:clear
# php artisan debug:clear
php artisan view:clear
php artisan migrate
# php artisan db:seed
php artisan config:cache
php artisan route:cache
# запустить приложение
# php artisan up
# npm run watch
#git pull
