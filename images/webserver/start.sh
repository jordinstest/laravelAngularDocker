#!/bin/bash
cp /opt/etc/nginx.conf /etc/nginx/nginx.conf
cp /opt/etc/api.conf /etc/nginx/sites-enabled/api.conf

sed -i "s/WORKER_PORT_9000_TCP_ADDR/$WORKER_PORT_9000_TCP_ADDR/" /etc/nginx/nginx.conf

nginx -t

sudo service nginx restart
exec "$@"
