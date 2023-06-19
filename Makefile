setup:
    @make build
    @make up
    @make composer-update
    @make data

build:
    docker-compose build --no-cache --force-rm

stop:
    docker-compose stop

up:
    docker-compose up -d

composer-update:
    docker exec plan-marketing_test_app bash -c "composer update"

data:
    docker exec plan-marketing_test_app bash -c "php artisan migrate"
    docker exec plan-marketing_test_app bash -c "php artisan db:seed"