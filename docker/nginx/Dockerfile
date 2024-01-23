FROM nginx:alpine

COPY nginx.conf /etc/nginx/
COPY default.conf /etc/nginx/conf.d/

RUN apk update && apk upgrade && apk add --no-cache bash

ARG PHP_SALESTIO_CONTAINER=php-fpm
ARG PHP_SALESTIO_PORT=9000

RUN set -x ; \
    apk --no-cache add shadow ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data

RUN echo "salestio php-salestio { server ${PHP_SALESTIO_CONTAINER}:${PHP_SALESTIO_PORT}; }"

EXPOSE 80