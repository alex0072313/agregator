SHELL := /usr/bin/env bash
up:
	export UID && docker-compose up -d

down:
	docker-compose down -v

build:
	export UID && docker-compose build --pull

bash:
	export UID && docker-compose run --rm app bash

composer_bash:
	export UID && docker-compose run --rm composer bash

migrate:
	docker-compose exec app sh -c 'php db_migrate.php;'

push_jobs:
	docker-compose exec app sh -c 'while true; do php send.php; done;'

clean:
	docker rm -f $(shell docker ps -qa)
	docker rmi < echo $(shell docker images -q | tr "\n" " ")

logs:
	docker-compose logs -f

