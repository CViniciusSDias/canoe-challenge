FROM php:8.3-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN pecl install swoole && docker-php-ext-enable swoole

RUN apt update && apt install -y zip unzip

RUN apt install -y libpq-dev && docker-php-ext-install pdo_pgsql