FROM php:fpm-alpine

RUN apk update \
	&& apk add --no-cache git zip unzip zlib-dev g++ make autoconf \
	&& curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer \
    && rm -rf /var/cache/apk/*