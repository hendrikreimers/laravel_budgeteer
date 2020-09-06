#! /bin/bash

source ./install-dev.sh
npm run prod

rm -Rf ./node_modules
rm -Rf ./vendor

#cd ..
php artisan cache:clear
rm -f ./storage/framework/*/*.php
npm install --production
composer install --no-dev
rm -Rf ./node_modules
