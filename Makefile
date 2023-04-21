.DEFAULT_GOAL := help

# -----------------------------------
# Variables
# -----------------------------------
is_docker := $(shell docker info > /dev/null 2>&1 && echo 1)
user := $(shell id -u)
group := $(shell id -g)

ifeq ($(is_docker), 1)
	dc := USER_ID=$(user) GROUP_ID=$(group) docker-compose
	de := docker-compose exec
	dr := $(dc) run --rm
	lc := $(dr) php artisan
	node := $(dr) --user="$(user)" node
	php := $(dr) --no-deps php
	phptest := $(dr) php_test
	composer := $(php) composer
else
	php := php
	node := node
	composer := composer
	lc := $(php) artisan
endif


.PHONY: help
help: ## Affiche cette aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'


.PHONY: install
install: vendor/autoload.php ## Installe les différentes dépendances
	$(composer) install

.PHONY: migrate
migrate: vendor/autoload.php ## Migre la base de donnée
	$(lc) migrate

.PHONY: fresh
fresh: vendor/autoload.php
	$(lc) migrate:fresh --seed

.PHONY: seeder
seeder: vendor/autoload.php
	$(lc) db:seed

.PHONY: test
test: vendor/autoload.php ## Lance les tests
	$(lc) test

.PHONY: serve
serve: vendor/autoload.php ## Lance le serveur
	$(lc) serve

.PHONY: clear
clear: vendor/autoload.php ## vide le cache de l'application
	$(lc) cache:clear
	$(lc) view:clear
	$(lc) route:clear

.PHONY: start
start: vendor/autoload.php ## lance, le serve de development
	npm run dev
