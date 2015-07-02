FROM ubuntu:trusty

MAINTAINER Ewan Valentine <ewan@theladbible.com>

WORKDIR /tmp

RUN apt-get update -y && \
    apt-get install -y \
    php5-cli \
    php5-mcrypt \
    php5-mongo \
    php5-mssql \
    php5-mysqlnd \
    php5-pgsql \
    php5-redis \
    php5-sqlite \
    php5-gd

RUN mkdir -p /var/www/api
VOLUME ["/var"]
WORKDIR /var/www/api

ENTRYPOINT ["php", "artisan"]
CMD ["--help"]
