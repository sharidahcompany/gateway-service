FROM ghcr.io/sharidahcompany/ceo-app-base:latest

# Set working directory
WORKDIR /var/www

# Copy app code
COPY . /var/www

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
                                                         