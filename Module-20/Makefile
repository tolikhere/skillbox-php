composer-req:
	docker run --rm --interactive --tty \
	--workdir="/var/www/" \
	--volume $(CURDIR)/src:/var/www \
	--user $$(id -u):$$(id -g) \
	--name composer \
	composer require $(package)

composer-dump:
	docker run --rm --interactive --tty \
	--workdir="/var/www/" \
	--volume $(CURDIR)/src:/var/www \
	--user $$(id -u):$$(id -g) \
	--name composer \
	composer dump-autoload
