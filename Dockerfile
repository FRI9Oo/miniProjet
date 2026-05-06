FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libonig-dev libxml2-dev libzip-dev default-mysql-client

RUN docker-php-ext-install pdo pdo_mysql zip

# Disable all MPM modules first to prevent conflicts
RUN a2dismod mpm_event mpm_worker mpm_prefork 2>/dev/null || true

# Remove MPM module load statements from Apache config to prevent automatic loading
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load 2>/dev/null || true && \
    rm -f /etc/apache2/mods-available/mpm_*.load 2>/dev/null || true

# Enable only mpm_prefork
RUN a2enmod mpm_prefork

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]