FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libicu-dev \
    libpq-dev \
    libmcrypt-dev

RUN docker-php-ext-install \
    intl \
    zip \
    pdo_mysql \
    opcache \
    bcmath

## Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Create user and group www-data
RUN usermod -aG www-data www-data
USER 1000:1000

#Define Local de trabalho ao entrar no Container
WORKDIR /pay-api

EXPOSE 9000
