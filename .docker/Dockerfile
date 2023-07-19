FROM php:8.0-alpine3.16
COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer

RUN apk update \
    && apk add --no-cache linux-headers autoconf make build-base \
	&& pecl install xdebug-3.2.2 \
	&& docker-php-ext-enable xdebug \
    && echo -e "xdebug.mode=debug\n\
            xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /app
