FROM ubuntu:trusty

MAINTAINER Ewan Valentine <ewan@theladbible.com>

# Install Nginx.
RUN \
  apt-get install -y software-properties-common && \
  add-apt-repository -y ppa:nginx/stable && \
  apt-get update && \
  apt-get install -y nginx && \
  rm -rf /var/lib/apt/lists/* && \
  echo "\ndaemon off;" >> /etc/nginx/nginx.conf && \
  chown -R www-data:www-data /var/lib/nginx

# Only use stable sources
RUN rm -rf /etc/apt/sources.list.d/proposed.list

# Install packages
RUN apt-get update && \
  apt-get install -y \
  curl \
  wget \
  php5-fpm \
  php5-mysql \
  php5-mcrypt \
  php5-gd \
  php5-memcached \
  php5-curl \
  php5-xdebug

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Create required directories
RUN mkdir -p /etc/nginx && \
    mkdir -p /var/run/php5-fpm && \
    mkdir -p /etc/nginx/sites-enabled && \
    mkdir -p /var/log/nginx

RUN rm -rf /etc/nginx/sites-enabled/default

# Add configuration files
ADD php.ini /etc/php5/fpm/conf.d/40-custom.ini

# Expose volumes
VOLUME ["/var/www", "/etc/nginx/sites-enabled"]

EXPOSE 80

WORKDIR /var/www

CMD service php5-fpm start && nginx
