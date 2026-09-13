### base ###
FROM dunglas/frankenphp:1-php8.4 AS base

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && install-php-extensions intl zip curl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV SERVER_NAME=:80

WORKDIR /var/www/html
COPY . .


### prod ###
FROM base AS prod

RUN composer install --optimize-autoloader --no-scripts --no-dev
RUN php bin/console tailwind:build --env=prod
RUN php bin/console asset-map:compile --env=prod

ENV APP_CACHE_DIR=/tmp/symfony-cache

RUN echo "session.save_path = /tmp/sessions" > /usr/local/etc/php/conf.d/zz-lambda.ini

COPY --from=public.ecr.aws/awsguru/aws-lambda-adapter:1.0.1 /lambda-adapter /opt/extensions/lambda-adapter
ENV AWS_LWA_PORT=80

CMD ["sh", "bin/lambda-bootstrap"]


### dev ###
FROM base AS dev

RUN composer install --optimize-autoloader --no-scripts
CMD ["sh", "bin/dev"]
