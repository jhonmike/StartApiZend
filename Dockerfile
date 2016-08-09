FROM php:7.0.9-apache

RUN apt-get update \
 && apt-get install -y git zlib1g-dev wget \
 && echo "deb http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list.d/dotdeb.org.list \
 && echo "deb-src http://packages.dotdeb.org jessie all" >> /etc/apt/sources.list.d/dotdeb.org.list \
 && wget -O- http://www.dotdeb.org/dotdeb.gpg | apt-key add - \
 && apt-get update \
 && apt-get install -y php7.0-mysql \
 && docker-php-ext-install zip pdo pdo_mysql \
 && a2enmod rewrite \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
