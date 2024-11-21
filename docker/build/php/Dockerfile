FROM php:8.1-fpm

# Install zip extension
RUN apt-get update && apt-get install -y \
        libzip-dev \
        libmagickwand-dev \
        zip \
        git \
        curl \
  && docker-php-source extract \
  && docker-php-ext-install zip pdo_mysql sockets

RUN pecl install imagick  \
    && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini

 
RUN curl -sS https://getcomposer.org/installer \
       | php -- --install-dir=/usr/local/bin --filename=composer 
       


