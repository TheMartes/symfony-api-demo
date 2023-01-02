MIN_MAKE_VERSION := 3.82

ifneq ($(MIN_MAKE_VERSION),$(firstword $(sort $(MAKE_VERSION) $(MIN_MAKE_VERSION))))
$(error GNU Make $(MIN_MAKE_VERSION) or higher required)
endif

.DEFAULT_GOAL:=help

##@ Development
.PHONY: up build down composer-install cli-php cli-nginx
up: ## Serve Backedn
	docker-compose up

build: ## Build Backend
	docker-compose up --build

down: ## Shutdown Backend
	docker-compose down

composer-install: ## Install composer dependencies
	docker-compose up composer

cli-php: ## Get into backend PHP container (with composer)
	docker exec -it backend_php_1 sh

cli-nginx: ## Get into backend NGINX container
	docker exec -it backend_web_1 sh

##@ Tests
.PHONY: phpunit phpstan
phpunit: ## Run PHP Unit
	docker exec -it backend_web_1 /app/vendor/bin/phpunit tests

phpstan: ## Run PHP Stan
	docker exec -it backend_web_1 /app/vendor/bin/phpstan analyse src tests

##@ Fixtures
.PHONY: db-run-fixtures
db-run-fixtures: ## Run DB Fixtures
	docker exec -it backend_database_1 /fixtures/run_fixtures.sh

##@ Debugging
.PHONY: log
log: ## Read backend error log
	docker exec -it backend_web_1 tail -f /app/var/log/monolog.log

.PHONY: help
help:
	@awk 'BEGIN {FS = ":.*##"; printf "Usage: \033[36mmake \033[96m<target>\033[0m\n- use \033[96mapp=name\033[0m to specify app name (defaults to $(app))\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-25s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)
