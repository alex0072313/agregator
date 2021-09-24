FROM php:7.4-fpm

COPY ./docker/config/php.ini /usr/local/etc/php/php.ini

# Install dependencies
RUN apt-get update

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install mysqli pdo_mysql

COPY ./app /var/www/html
