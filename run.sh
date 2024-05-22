#!/bin/bash

docker-compose build
docker-compose up -d 
container_id=`docker ps -f "name=weather_backend" --format "{{.ID}}"` 
docker exec $container_id php /var/www/backend/composer.phar install