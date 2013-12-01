testobj=.

install:
	composer install

unittest:
	make install && @cd tests/unit/ && phpunit --colors $(testobj)

ctags:
	ctags -R --language-force=PHP src/ tests/unit/

phpdoc:
	phpdoc -d src/ -t docs/
