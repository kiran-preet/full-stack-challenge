#!/bin/bash
# Install composer dependencies if vendor folder doesn't exist
if [ ! -d "/var/www/html/vendor" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Continue with normal startup
exec "$@"

# Run migrations only if this is the first run
if [ ! -f "/var/www/html/.migrated" ]; then
    php artisan migrate --force
    php artisan db:seed --force
    touch /var/www/html/.migrated
fi

# Start server
php artisan serve --host=0.0.0.0 --port=8000