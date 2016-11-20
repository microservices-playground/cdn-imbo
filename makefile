composer.phar:
	curl -sS https://getcomposer.org/installer | php

install: composer.phar
	php composer.phar install
