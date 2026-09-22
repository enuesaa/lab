FROM dunglas/frankenphp:1-php8.4 AS base

RUN apt-get update \
    && apt-get install -y git unzip \
    && install-php-extensions intl zip curl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
COPY Caddyfile /etc/frankenphp/Caddyfile


### lambda ###
FROM base AS lambda

RUN composer install --optimize-autoloader --no-scripts

ENV APP_CACHE_DIR=/tmp/symfony-cache

COPY --from=public.ecr.aws/awsguru/aws-lambda-adapter:1.0.1 /lambda-adapter /opt/extensions/lambda-adapter
ENV AWS_LWA_PORT=8080


### local ###
FROM base AS local

CMD ["sh", "bin/dev"]
