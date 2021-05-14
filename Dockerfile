FROM alpine:3.11 AS base

ADD https://packages.whatwedo.ch/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub
RUN apk --update add ca-certificates

ADD https://packages.whatwedo.ch/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub

RUN apk add --update make curl grep
RUN echo "@php https://packages.whatwedo.ch/php-alpine/v3.11/php-8.0" >> /etc/apk/repositories
RUN apk add --update php@php php-mbstring@php php-dom@php php-gd@php php-xml@php php-iconv@php \
        php-curl@php php-bcmath@php php-openssl@php

RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*
RUN ln -s /usr/bin/php8 /usr/bin/php
RUN curl --insecure https://getcomposer.org/composer-stable.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

WORKDIR /var/www

CMD ["php", "-v"]