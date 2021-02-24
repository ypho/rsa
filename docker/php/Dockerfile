FROM php:7.4-fpm

# Install ZIP
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

# Install needed extensions
RUN pecl install pcov && docker-php-ext-enable pcov
RUN docker-php-ext-install bcmath

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /code
