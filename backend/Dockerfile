FROM php:7.2-fpm

RUN apt-get update
RUN apt-get install -y git vim

WORKDIR "/var/www/backend"

CMD ./bin/console server:run "0.0.0.0:8000"

