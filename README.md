# PEXE

A command-line harness to run [PECS](https://github.com/noonat/pecs) BDD tests.

Also has growl support (need to have growlnotify in your path).

## How to Install

Create a composer.json file with the following keys:

```js
{
    "require": {
		"nharbour/pexe": "dev-master"
    },
	"minimum-stability": "dev"
}
```

Make sure that you've installed [composer](http://getcomposer.org). Then run:

```
composer install
```

## Running PEXE

PEXE will install a binary in the "vendor/bin" folder called "pexe". You may wish to add this folder to your path or symlink it to somewhere in your path:

```
ln -sf vendor/bin/pexe /usr/local/bin
```

Then just run pexe from the command-line:

```
pexe
```

By default it expects all your tests to be present in a folder called "./tests".

Here's an example of some basic tests:

```php
<?php
describe('my first bdd test', function() {
	it('should run this code', function() {
		expect(true)->to_equal(true);
	});

	it('should run this code too', function() {
		expect(true)->to_equal(true);
	});
});

describe('check results of functions', function() {
	it('should fail', function() {
		assert(false);
	});
});

describe('handle exceptions', function() {
	it('should handle throwing exceptions', function() {
		throw new Exception('Blah');
	});

	it('should handle math exceptions', function() {
		$x = 42 / 0;
	});
});
```
