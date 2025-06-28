FROM php:8.3-fpm
LABEL maintaner="Sergey Nezbritskiy"

RUN apt update && apt upgrade --yes
RUN apt install --yes --no-install-recommends sudo nano vim wget git zip unzip git

RUN pecl channel-update pecl.php.net && pecl install xdebug-3.4.0 && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD start.sh /start.sh
RUN chmod +x /start.sh

ARG XDEBUG_PATH='/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini'
RUN echo 'xdebug.max_nesting_level = -1' >> $XDEBUG_PATH
RUN echo 'xdebug.mode=develop,coverage,debug' >> $XDEBUG_PATH
RUN echo 'xdebug.client_host=${XDEBUG_CLIENT_HOST}' >> $XDEBUG_PATH
RUN echo 'xdebug.client_port=9003' >> $XDEBUG_PATH
RUN echo 'xdebug.start_with_request=yes' >> $XDEBUG_PATH
RUN echo 'xdebug.idekey="PHPSTORM"' >> $XDEBUG_PATH
RUN echo 'xdebug.discover_client_host=1' >> $XDEBUG_PATH

RUN adduser apache
RUN echo '%apache ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers


