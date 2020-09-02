build:
	composer validate
	composer install

install: build

it: build
