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

COPY --from=public.ecr.aws/awsguru/aws-lambda-adapter:1.0.1 /lambda-adapter /opt/extensions/lambda-adapter
ENV AWS_LWA_PORT=8080

RUN composer install --no-dev --classmap-authoritative --no-scripts \
    && php bin/console cache:warmup --env=prod


### local ###
FROM base AS local

CMD ["sh", "bin/dev"]
