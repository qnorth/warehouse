FROM php:7.4-cli

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    nano \
    git \
    curl \
    unzip \
    graphviz

### Composer install
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer

COPY . /var/www
WORKDIR /var/www

RUN composer install

CMD [ "php", "./bin/console" ]
