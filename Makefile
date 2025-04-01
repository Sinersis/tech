Command := $(firstword $(MAKECMDGOALS))
Arguments := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

.PHONY: help
help: # Выводит все возможные команды
	@grep -E '^[a-zA-Z0-9 -]+:.*#'  Makefile | while read -r l; do printf "\033[1;32m$$(echo $$l | cut -f 1 -d':')\033[00m:$$(echo $$l | cut -f 2- -d'#')\n"; done

.PHONY: up
up: # Поднять окружение
	@cp .env.example .env
	@docker build -t tech-app -f ./docker/php.Dockerfile .
	@docker compose up -d --force-recreate --remove-orphans

.PHONY: down
down: # Удаление окружения
	@docker compose down --rmi local

.PHONY: composer
composer: # Ссылка на composer в контейнере, может принимать в себя аргументы. По флагам смотри доку.
	@docker compose exec app composer $(Arguments)

.PHONY: artisan
artisan: # Ссылка на artisan в контейнере, может принимать в себя аргументы. По флагам смотри доку.
	@docker compose exec app php artisan $(Arguments)

%::
	@true
