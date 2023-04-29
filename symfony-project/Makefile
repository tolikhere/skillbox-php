tests:
	symfony console doctrine:database:drop --force
	symfony console doctrine:database:create
	symfony console doctrine:migrations:migrate
	symfony console doctrine:fixtures:load
