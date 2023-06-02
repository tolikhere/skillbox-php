tests:
	symfony console doctrine:database:drop --force
	symfony console doctrine:database:create
	symfony console doctrine:migrations:migrate
	symfony console doctrine:fixtures:load

start:
	docker-compose start
	symfony server:start -d

stop:
	docker-compose stop
	symfony server:stop

up:
	docker-compose up -d
