FROM ubuntu:trusty

MAINTAINER Ewan Valentine <ewan@theladbible.com>

WORKDIR /tmp

RUN apt-get update -y && \
  apt-get install -y \
  curl \
  wget \
  php5-cli \
  php5-mcrypt \
  php5-fpm \
  php5-curl \
  php5-xdebug

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN composer self-update

RUN mkdir -p /var/www
VOLUME ["/var"]
WORKDIR /var/www/api

ENTRYPOINT ["composer"]
CMD ["--help"]
