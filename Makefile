install:
	composer install
lint:
	composer exec --verbose phpcs
	composer exec --verbose phpstan
lint-fix:
	composer exec --verbose phpcbf
test:
	composer exec --verbose phpunit
