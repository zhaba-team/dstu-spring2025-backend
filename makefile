include .env

build:
	@echo "Building containers"
	@docker compose --env-file .env up -d --build

up:
	@echo "Starting containers"
	@docker compose --env-file .env up -d --remove-orphans
build-prod:
	@echo "Building containers"
	@docker compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env up -d --build

up-prod:
	@echo "Starting containers"
	@docker compose -f docker-compose.yml -f docker-compose.prod.yml --env-file .env up -d --remove-orphans

shell:
	@docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) /bin/bash

code-check:
	@echo "Perform a static analysis of the code base"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) vendor/bin/phpstan analyse --memory-limit=2G
	@echo "Perform a code rector"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer cs-rector
	@echo "Perform a code style check"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer cs-check

rector-fix:
	@echo "Fix code with rector"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) composer cs-rector-fix

code-baseline:
	@echo "Perform phpstan generate-baseline"
	@DOCKER_CLI_HINTS=false docker exec -it $$(docker ps -q -f name=php.${APP_NAMESPACE}) vendor/bin/phpstan analyse --generate-baseline --memory-limit=2G
