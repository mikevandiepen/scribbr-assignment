ARG version

FROM php:${version}-fpm

# Installing extensions used for debugging and testing.
RUN pecl install -o -f xdebug \
    && docker-php-ext-enable xdebug
