FROM php:8.4-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    sqlite-dev \
    unzip \
    zip

# Install PHP extensions
RUN docker-php-ext-install pcntl pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction && \
    rm composer.json composer.lock

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

# Expose port
EXPOSE 8080

# Set Framework X server to listen on all interfaces
ENV X_LISTEN=0.0.0.0:8080

# Start Framework X server
CMD ["php", "public/index.php"]