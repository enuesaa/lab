### base
FROM php:8.4-apache AS base

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install intl zip pdo_mysql

# apache
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

WORKDIR /var/www/html

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
# RUN composer install --optimize-autoloader --no-scripts
# RUN php bin/console tailwind:build

CMD ["apache2-foreground"]


### dev
FROM base AS dev

# symfony cli
COPY --link --from=ghcr.io/symfony-cli/symfony-cli:latest \
    /usr/local/bin/symfony /usr/local/bin/symfony

CMD ["symfony", "server:start", "--allow-all-ip"]
