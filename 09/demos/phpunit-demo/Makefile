test:
	docker-compose run php bash -c "vendor/bin/phpunit -c phpunit.xml"
init:
	docker-compose up -d && docker-compose run php bash -c "composer install"
