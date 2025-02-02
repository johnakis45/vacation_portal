# Use the official PHP image with Apache
FROM php:8.2-apache

# Install the MySQLi extension
RUN docker-php-ext-install mysqli
