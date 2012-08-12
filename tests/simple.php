<?php
describe('my first bdd test', function() {
	it('should run this code', function() {
		expect(true)->to_equal(true);
	});

	it('should run this code too', function() {
		expect(true)->to_equal(true);
	});
});

describe('handle exceptions', function() {
	it('should handle throwing exceptions', function() {
		expect(function() {
			throw new Exception('Blah');
		})->to_throw('Exception');
	});

	it('should handle math exceptions', function() {
		expect(function() {
			$x = 42 / 0;
		})->to_throw();
	});
});
