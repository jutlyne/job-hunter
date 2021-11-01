LARADOCK=laradock_carecar

# container names
PHP_CONTAINER_NAME=$(LARADOCK)_php-fpm_1
DB_CONTAINER_NAME=$(LARADOCK)_mysql_1
WORKSPACE_CONTAINER_NAME=$(LARADOCK)_workspace_1
NODE_IMAGE_NAME=node

LIST_OF_CONTAINERS_TO_RUN=nginx mysql workspace


# some variables that required by installation target
LARADOCK_REPO=https://github.com/Laradock/laradock.git
LARADOCK_NGINX_PORT=8084

# the first target is the one that executed by default
# when uesr call make with no target.
# let's do nothing in this case
.PHONY: nop
nop:
	@echo "Please pass a target you want to run"

# custom targets

# put them here

#--------


# clone the repo
# replace some variabls in laradock's .env file
# create and update .env file of laravel
# replace some env variables in laravel's .env file
.PHONY: install-laradock
install-laradock:
	git config core.fileMode false
	git clone $(LARADOCK_REPO) $(LARADOCK)
	cp $(LARADOCK)/env-example $(LARADOCK)/.env
	sed -ie 's/COMPOSE_PROJECT_NAME=laradock/COMPOSE_PROJECT_NAME=laradock_carecar/' $(LARADOCK)/.env
	sed -ie 's/MYSQL_VERSION=latest/MYSQL_VERSION=5.7/' $(LARADOCK)/.env
	sed -ie 's/PHP_FPM_INSTALL_IMAGEMAGICK=true/PHP_FPM_INSTALL_IMAGEMAGICK=false/' $(LARADOCK)/.env
	sed -ie 's/DATA_PATH_HOST=.*/DATA_PATH_HOST=..\/docker-data/' $(LARADOCK)/.env
	sed -ie 's/NGINX_HOST_HTTP_PORT=80/NGINX_HOST_HTTP_PORT=$(LARADOCK_NGINX_PORT)/' $(LARADOCK)/.env
	(test -s .env || cp .env.example .env) ; \
	sed -ie 's/DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
	sed -ie 's/DB_HOST=.*/DB_HOST=mysql/' .env
	sed -ie 's/DB_DATABASE=.*/DB_DATABASE=default/' .env
	sed -ie 's/DB_USERNAME=.*/DB_USERNAME=default/' .env
	sed -ie 's/DB_PASSWORD=.*/DB_PASSWORD=secret/' .env
	sudo chmod -R 777 storage

# run all containers
.PHONY: up
up:
	cd $(LARADOCK) && docker-compose up -d $(LIST_OF_CONTAINERS_TO_RUN)

# stop all containers
.PHONY: down
down:
	cd $(LARADOCK) && docker-compose stop && docker-compose rm -f

# show laravel's log in realtime
.PHONY: log
log:
	tail -f storage/logs/laravel.log

# show docker log
.PHONY: docker-log
docker-log:
	cd $(LARADOCK) && docker-compose logs -f

# JOIN containers targets

.PHONY: join-workspace
join-workspace:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) bash

.PHONY: join-php
join-php:
	docker exec -it $(PHP_CONTAINER_NAME) bash

.PHONY: join-db
join-db:
	docker exec -it $(DB_CONTAINER_NAME) mysql -u default -psecret default
#------------------

# javascript related targets
.PHONY:  build-js
build-js:
	docker run --rm -it -v $(CURDIR):/app -w="/app" node bash -c 'npm run-script dev'

.PHONY:  build-js-production
build-js-production:
	docker run --rm -it -v $(CURDIR):/app -w="/app" node bash -c 'npm run production --silent'
.PHONY:  npm-install
npm-install:
	docker run --rm -it -v $(CURDIR):/app -w="/app" node bash -c 'npm install'

.PHONY: watch-js
watch-js:
	docker run --rm -it -v $(CURDIR):/app -w="/app" node bash -c 'npm run-script watch'
#------------------

# some artisan helpers

.PHONY: key-genrate
key-generate:
	docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan key:generate'

.PHONY:  new-migration
new-migration:
	@read -p "Migration name: " migrationname; \
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan make:migration $$migrationname";

.PHONY:  run-migrations
run-migrations:
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan migrate"

.PHONY: run-seeds
run-seeds:
	docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan db:seed'
#------------------

# run tests with phpunit
.PHONY: test
test:
	docker exec -it $(PHP_CONTAINER_NAME) ./vendor/bin/phpunit

# run tests with phpunit
.PHONY: composer-install
composer-install:
	docker exec -it $(WORKSPACE_CONTAINER_NAME) composer install