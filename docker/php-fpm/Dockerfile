FROM php:8.2.0-fpm-alpine

RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash

ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow
RUN groupmod -o -g 1000 www-data && \
    usermod -o -u 1000 -g www-data www-data

COPY ./ /var/www
WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm

EXPOSE 9000