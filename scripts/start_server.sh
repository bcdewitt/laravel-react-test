#!/bin/bash
set -o pipefail

cd /var/www/api

# Run migrations & seeding logic against database
php artisan migrate --force
php artisan db:seed --force
php artisan optimize

# Start Apache service
service apache2 start
