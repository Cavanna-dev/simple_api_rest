Starting
==================================

- Run `composer install` to update dependencies
- Run `docker-compose build` to build container
- Run `docker-compose up` to run containers

(wait for 5s, mysql container is taking his time, and do want to spend time implementing a healthchecker to do the job)

Explaining:

3 containers to rule them all:

PHP-FPM | MYSQL | NGINX

Everything's related to the config is located in ./docker and .env (did not want to waste time on creating a .env.dist)

We expose http://127.0.0.1:8080

- (optionnal) Run `docker-compose exec php-fpm bin/console hautelook:fixtures:load`

    docker-compose exec php-fpm => Access the container php-fpm
bin/console hautelook:fixtures:load => Create fixtures for the project

    You will have a plenty of data, but if you want to test the API to create data, you can use your favorite client to create it

*CURL example*

`curl -d '{"title":"test", "description":"test"}' -H "Content-Type: application/json" -X POST http://127.0.0.1:8080/articles`

Then you can check out the new 2019 design at

Want to check every articles? http://127.0.0.1:8080/blog/articles

Want to read the last trend article? http://127.0.0.1:8080/blog/article/1
