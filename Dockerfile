FROM ghcr.io/sharidahcompany/ceo-app-base:latest

# Set working directory
WORKDIR /var/www

# Copy app code
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
                                                         

