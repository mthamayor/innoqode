docker-compose up -d \
&& docker-compose run --rm composer install \
&& docker-compose run --rm composer run test