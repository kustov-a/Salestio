build:
	docker-compose -f ./docker/docker-compose.yml build

start:
	docker-compose -f ./docker/docker-compose.yml start

stop:
	docker-compose -f ./docker/docker-compose.yml stop

up:
	docker-compose -f ./docker/docker-compose.yml up -d --remove-orphans

down:
	docker-compose -f ./docker/docker-compose.yml down -d --remove-orphans

ps:
	docker-compose -f ./docker/docker-compose.yml ps

logs:
	docker-compose -f ./docker/docker-compose.yml logs -f

bash:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bash