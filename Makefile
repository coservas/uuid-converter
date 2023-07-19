.DEFAULT_GOAL := help

# COLORS
GREEN  := $(shell tput -Txterm setaf 2)
WHITE  := $(shell tput -Txterm setaf 7)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)

HELP_FUN = \
    %help; \
    while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([a-zA-Z\-]+)\s*:.*\#\#(?:@([a-zA-Z\-]+))?\s(.*)$$/ }; \
    print "usage: make [target]\n\n"; \
    for (sort keys %help) { \
    print "${WHITE}$$_:${RESET}\n"; \
    for (@{$$help{$$_}}) { \
    $$sep = " " x (32 - length $$_->[0]); \
    print "  ${YELLOW}$$_->[0]${RESET}$$sep${GREEN}$$_->[1]${RESET}\n"; \
    }; \
    print "\n"; }

DC = PROJECT_PATH=$(shell dirname $(shell pwd)) \
			 USER_ID=$(shell id -u) \
			 GROUP_ID=$(shell id -g) \
			 docker compose -f ./.docker/docker-compose.yml

DC_EXEC = $(DC) run php

help:
	@perl -e '$(HELP_FUN)' $(MAKEFILE_LIST)

.PHONY: build
build: ##@app Build app image
	@$(DC) build php

.PHONY: composer-install
composer-install: ##@app Install packages
	@$(DC_EXEC) composer install --no-interaction --prefer-dist

.PHONY: composer-update
composer-update: ##@app Update dependencies
	@$(DC_EXEC) composer update

.PHONY: bash
sh: ##@app Execute "sh" on image
	@$(DC_EXEC) sh

.PHONY: test
test: ##@tests Run tests with coverage
	@$(DC_EXEC) vendor/bin/phpunit -c phpunit.xml.dist --coverage-clover=./clover.xml --coverage-text --coverage-html=./coverage/

.PHONY: stan
stan: ##@clean-code Analyse code with PhpStan
	@$(DC_EXEC) vendor/bin/phpstan analyse -l max src