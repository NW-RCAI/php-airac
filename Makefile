build:
	docker build . -t php-airac

up:
	docker run -v ~/work/php-airac:/var/www -it --rm php-airac /bin/ash

test:
	docker run -v ~/work/php-airac:/var/www -it --rm php-airac vendor/bin/phpcs --standard=PSR2 --encoding=utf-8 src 
	docker run -v ~/work/php-airac:/var/www -it --rm php-airac vendor/bin/phpunit --configuration ./phpunit.xml.dist

