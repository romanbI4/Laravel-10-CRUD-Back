# Executables (local)
DOCKER_FOLDER = cd docker;
DOCKER_COMP = $(DOCKER_FOLDER) docker-compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php-fpm

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
ARTISAN  = $(PHP_CONT) artisan

# Misc
.DEFAULT_GOAL = help
.PHONY        = help build up start down logs sh composer vendor sf cc

## —— 🎵 🐳 The Symfony-docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach

start: build up generate-key chmod migrate

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

chmod:
	@$(PHP_CONT) sh -c "cd backend; chmod 777 -R storage; chmod 777 -R storage/logs; chmod 777 -R database/migrations; chmod 777 -R database/factories; chmod 777 -R database/seeds; chmod 777 -R resources;"

sh: ## Connect to the PHP FPM container
	@$(PHP_CONT) sh

generate-key:
	@$(PHP_CONT) sh -c "cd backend; php artisan key:generate"

migrate:
	@$(PHP_CONT) sh -c "cd backend; php artisan migrate:fresh"

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

## —— FRONT  ———————————————————————————————————————————————————————————————————

admin-watch:
	$(PHP_CONT) sh -c "cd backend; npm run watch"

admin-build:
	$(PHP_CONT) sh -c "cd backend; composer require laravel/ui:^2.4; php artisan ui vue"

npm-install:
	$(PHP_CONT) sh -c "cd backend; npm install;"

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer