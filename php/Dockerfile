FROM php:7.4.28-fpm-alpine3.15
RUN apk update; \
    apk upgrade;
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN docker-php-ext-install mysqli