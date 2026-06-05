FROM dunglas/frankenphp:php8.5.6-bookworm

# Install required PHP extensions
RUN docker-php-ext-install intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# Expose port
EXPOSE 80

# Start FrankenPHP
CMD ["frankenphp", "run", "--bind=0.0.0.0:80"]

