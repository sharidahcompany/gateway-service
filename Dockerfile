FROM ghcr.io/sharidahcompany/ceo-app-base:latest

# Set working directory
WORKDIR /srv/ceo-app/microservices/gateway_service

# Copy app code
COPY . /srv/ceo-app/microservices/gateway_service

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /srv/ceo-app/microservices/gateway_service

EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
