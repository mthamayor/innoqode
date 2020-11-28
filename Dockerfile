FROM php:7.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-beta \
    && pecl install pcov \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable pcov