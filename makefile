include .env

restart: stop up

update-project: pull composer-install db-migrate create-search-index build-admin rebuild

build:
	@echo "Building containers"
	@docker compose --env-file .env build

up:
	@echo "Starting containers"
	@docker compose --env-file .env up -d --remove-orphans

rebuild:
	@echo "Rebuilding containers"
	@docker compose up -d --build

stop:
	@echo "Stopping containers"
	@docker compose stop

shell:
	@docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) /bin/bash

composer-install:
	@echo "Running composer install"
	@docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer install

composer-update:
	@echo "Running composer install"
	@docker exec -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.php-fpm) composer update

db-migrate:
	@echo "Running database migrations"
	@docker exec -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.php-fpm) php artisan migrate --force

create-search-index:
	@echo "Running database migrations"
	@docker exec -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.php-fpm) php artisan search:index

set-permissions:
	@echo "Changing permissions for specific directories"
	@docker exec -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.php-fpm) chmod -R 0777 storage

build-admin:
	@echo "Building admin frontend for production"
	@docker exec --workdir /backend  -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.nodejs) npm i --production=false
	@docker exec --workdir /backend  -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.nodejs) npm run build:admin

restore-db:
	@echo "Restore database dump from file ${DB_DATABASE}.sql"
	@docker exec -i $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.mariadb) mariadb -u${DB_USERNAME} -p"${DB_PASSWORD}" ${DB_DATABASE} < ${DB_DATABASE}.sql

backup-db:
	@echo "Backup database to ${DB_DATABASE}_1.sql"
	@docker exec $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.mariadb) mariadb-dump -u${DB_USERNAME} -p"${DB_PASSWORD}" ${DB_DATABASE} > ${DB_DATABASE}_1.sql

pull:
	@echo "Updating project from git and rebuild"
	@git pull origin master
	@cd ../lucky-try && git pull origin main
	@cd ../lucky-try-backend

code-check:
	@echo "Perform a static analysis of the code base"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.php-fpm) vendor/bin/phpstan analyse --memory-limit=2G
	@echo "Perform a code style check"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.php-fpm) composer cs-check

code-baseline:
	@echo "Perform phpstan generate-baseline"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=${COMPOSE_PROJECT_NAME}.php-fpm) vendor/bin/phpstan analyse --generate-baseline --memory-limit=2G

gen-ssl:
	@docker compose run --rm  certbot certonly --webroot --webroot-path /var/www/certbot/ -d luckytry.online -d www.luckytry.online -d mail.luckytry.online -d luckytrygames.com -d www.luckytrygames.com -d mail.luckytrygames.com

update-ssl:
	@docker compose run --rm certbot renew
