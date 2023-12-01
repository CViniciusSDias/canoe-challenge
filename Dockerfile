FROM php:8.3-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt update && apt install -y zip unzip

RUN apt install -y libpq-dev && docker-php-ext-install pdo_pgsql

RUN apt install -y librabbitmq-dev && pecl install amqp && docker-php-ext-enable amqp