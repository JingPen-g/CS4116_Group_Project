# Use the base PHP 7.4 FPM image
FROM php:8.0-fpm

# Install MySQLi extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Set working directory
WORKDIR /var/www/html

# Expose the PHP-FPM port (default 9000)
EXPOSE 9000
USER 0
