FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN apt-get update && apt-get install zip unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get install -y libmemcached-dev zlib1g-dev && pecl install memcache && docker-php-ext-enable memcache

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
