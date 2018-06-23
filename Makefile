.DEFAULT_GOAL := check
.PHONY: lint phpcpd phpstan phpcs phpcbf tests echo-failed-tests composer-install

PHPCS_ARGS := --standard=ruleset.xml --extensions=php,phpt --encoding=utf-8 --tab-width=4 -sp Core Tests
TESTER_ARGS := -o console -s -p php -c Tests/php.ini

check: lint phpcpd phpstan phpcs tests
ci: lint phpcpd phpstan phpcs tests

lint:
	vendor/bin/parallel-lint -e php,phpt Core Tests

phpcpd:
	vendor/bin/phpcpd Core

phpstan:
	vendor/bin/phpstan analyse -l max -c phpstan.neon Core Tests

phpcs:
	vendor/bin/phpcs $(PHPCS_ARGS)

phpcbf:
	vendor/bin/phpcbf $(PHPCS_ARGS)

tests:
	vendor/bin/tester $(TESTER_ARGS) Tests/

echo-failed-tests:
	@for i in $(find Tests -name \*.actual); do echo "--- $i"; cat $i; echo; echo; done
	@for i in $(find Tests -name \*.expected); do echo "--- $i"; cat $i; echo; echo; done

composer-install:
	composer install --no-interaction --prefer-dist --no-scripts --no-progress --no-suggest --optimize-autoloader --classmap-authoritative
