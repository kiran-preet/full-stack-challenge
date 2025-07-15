# Dockerfile for Laravel PHP app
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
# ...existing code...
COPY . /var/www/html


# Install Composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install Node dependencies
RUN npm install

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

#delete if already exists to avoid integrity issues
# This ensures that the database file is fresh and ready for migrations
RUN rm -f /var/www/html/database/database.sqlite
# Ensure SQLite database file exists
RUN touch /var/www/html/database/database.sqlite

# Expose ports for backend and frontend
EXPOSE 8000 5173

# Start both Laravel and Vite dev servers
CMD bash -c "php artisan migrate --force && php artisan db:seed --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=8000 & npm run build -- --host 0.0.0.0 --port 5173"
