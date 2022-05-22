FROM php:8.1-fpm
ARG TIMEZONE="Europe/Paris"
RUN apt-get update && apt-get install -y \
           openssl \
           git \
           unzip \
           libpng-dev \
           libxml2-dev \
           libzip-dev \
           libcurl4-gnutls-dev \
           libonig-dev \
           libpq-dev \
           fontconfig \
           libfreetype6 \
           libjpeg62-turbo \
           libxrender1 \
           xfonts-75dpi \
           xfonts-base \
           wget \
           libssl-dev

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

RUN docker-php-ext-install pdo pdo_mysql opcache zip curl mbstring xml intl

RUN pecl install apcu mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini
RUN docker-php-ext-enable apcu mongodb
    
WORKDIR /usr/src/app
    
COPY --chown=1000:1000 ./ /usr/src/app
    
RUN PATH=$PATH:/usr/src/app/vendor/bin:bin

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

