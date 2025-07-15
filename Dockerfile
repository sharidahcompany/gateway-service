FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libonig-dev librdkafka-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set default working directory (optional)
WORKDIR /var/www


