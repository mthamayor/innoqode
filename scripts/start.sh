docker-compose up -d \
&& docker-compose exec php composer install \
&& docker-compose run --rm artisan migrate