FROM php:7.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-beta \
    && docker-php-ext-enable xdebug