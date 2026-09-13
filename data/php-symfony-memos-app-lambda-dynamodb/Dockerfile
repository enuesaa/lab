### base ###
FROM php:8.4-apache AS base

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libicu-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install intl zip curl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .


### prod ###
FROM base AS prod

ENV APP_ENV=prod
ENV APP_DEBUG=0

RUN composer install --optimize-autoloader --no-scripts --no-dev
RUN php bin/console tailwind:build --env=prod
RUN php bin/console asset-map:compile --env=prod

RUN sed -i \
    -e 's#^export APACHE_PID_FILE=.*#export APACHE_PID_FILE=/tmp/apache2/apache2.pid#' \
    -e 's#^export APACHE_RUN_DIR=.*#export APACHE_RUN_DIR=/tmp/apache2/run#' \
    -e 's#^export APACHE_LOCK_DIR=.*#export APACHE_LOCK_DIR=/tmp/apache2/lock#' \
    -e 's#^export APACHE_LOG_DIR=.*#export APACHE_LOG_DIR=/tmp/apache2/log#' \
    /etc/apache2/envvars
RUN echo "session.save_path = /tmp/sessions" > /usr/local/etc/php/conf.d/zz-lambda.ini

COPY --from=public.ecr.aws/awsguru/aws-lambda-adapter:0.9.1 /lambda-adapter /opt/extensions/lambda-adapter
ENV AWS_LWA_PORT=80

RUN chmod +x bin/lambda-bootstrap
CMD ["sh", "bin/lambda-bootstrap"]


### dev ###
FROM base AS dev

RUN composer install --optimize-autoloader --no-scripts
CMD ["sh", "bin/dev"]
