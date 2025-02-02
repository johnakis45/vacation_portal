# Use the official PHP 8.2 Apache image as the base
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy Composer from the composer image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer


# Install PHPUnit
RUN curl -sS https://phar.phpunit.de/phpunit-10.phar -o /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/phpunit

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Set correct permissions for tests
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Set entrypoint to Apache
CMD ["apache2-foreground"]
