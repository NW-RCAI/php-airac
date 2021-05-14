FROM alpine:3.7 AS base

ADD https://php.codecasts.rocks/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub
RUN apk --update add ca-certificates
RUN echo "@php https://php.codecasts.rocks/v3.7/php-7.1" >> /etc/apk/repositories

RUN apk add --update \
    make \
    curl \
    # for post-update-cmd of composer
    grep

RUN apk add --update \
    php@php \
    php-json@php \
    php-mbstring@php \
    php-dom@php \
    php-gd@php \
    php-xml@php \
    php-iconv@php \
    php-curl@php \
    php-bcmath@php \
    # for install/update vendor by composer
    php7-phar@php \
    php7-openssl@php

RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*
RUN ln -s /usr/bin/php7 /usr/bin/php
RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

WORKDIR /var/www

CMD ["php", "-v"]
