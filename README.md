# utility

[![Actions Status](https://github.com/ronanchilvers/utility/workflows/Unit%20Tests/badge.svg)](https://github.com/ronanchilvers/utility/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ronanchilvers/utility/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ronanchilvers/utility/?branch=master)

The package is intended provides a set of classes and methods that help with common tasks in PHP projects.

## Installation

```
composer require ronanchilvers/utility
```



## Usage

### `Str` - String handling

The `Str` class provides some useful methods for dealing with strings.

### `Str::plural($string, $count = 1, $plural = false)`

Pluralise a string. Provide a singular word and count and `plural()` will pluralise it if appropriate. If its an odd word that doesn't pluralise easily, you can supply the plural you want to use as a third argument.

### `Str::singular($string, $count = 1, $singular = false)`

Singularise a plural string. Provide a plural word and an optional count and `singular()` will do its best to singularise it for you. If it gets it wrong you can pass an explicit singular as a third argument.

### `Str::pascal($string,  $allowed = [])`

Convert a string to PascalCase. This method will by default remove any characters except a-z and 0-9. If you have additional characters you'd like to retain pass them as an array of strings in the `$allowed` argument.

### `Str::camel($string, $allowed = [])`

Convert a string to camelCase. This method returns the same result as `pascal()` except that the first character of the returned string is lowercased.

### `Str::snake($string, $allowed = [])`

Convert a string to snake_case. As with `pascal()`, this method removes all characters except a-z and 0-9. You can use the second argument `$allowed` to pass an array of additional characters that you want to keep.

### `Str::truncate($string, $length, $suffix = '...', $words = false)`

Truncate a string to a given length. By default the string is suffixed with an ellipsis (`…`) but you can change this by passing a suffix string in the third argument (`$suffix`). In addition `truncate()` will split a string without regard for word boundaries. If you want to respect words pass `true` as the fourth `$words` argument.

### `Str::token($length = 64)`

Generate a random string token of a given length.

### `Str::bool($string)`

Determine if a string means true or false.

## Testing

The utility classes are very simple and consequently  have 100% test coverage. You can run the tests by doing:

```
./vendor/bin/phpunit
```

The default phpunit.xml.dist file creates coverage information in a build/coverage subdirectory.

## Contributing

If anyone has any patches they want to contribute I'd be more than happy to review them. Please raise a PR. You should:

* Follow PSR2
* Maintain 100% test coverage or give the reasons why you aren't
* Follow a one feature per pull request rule

## License

This software is licensed under the MIT license. Please see the [License File](LICENSE.md) for more information.
