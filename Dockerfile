# Use an official PHP + Apache image
FROM php:8.2-apache

# Enable mod_rewrite for clean URLs
RUN a2enmod rewrite

# Copy app source code to Apache directory
COPY . /var/www/html/

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 80
