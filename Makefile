build:
	composer validate
	composer install
	bin/console c:c

install: build

start:
	symfony server:start

it: build start

phpstan:
	./vendor/bin/phpstan analyse src tests --level 6
test:
	php vendor/bin/codecept run --steps

qa: phpstan

cs:
	./vendor/bin/php-cs-fixer fix
