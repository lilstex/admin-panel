#!/bin/bash

# Run Laravel migration
php artisan migrate

# Generate Laravel application key
php artisan key:generate

# Clear Laravel cache
php artisan cache:clear

# Clear Laravel configuration cache
php artisan config:clear

# Clear Laravel route cache
php artisan route:clear

# Start the Laravel server
php artisan serve --port="$PORT" --host=0.0.0.0 --env=.env
