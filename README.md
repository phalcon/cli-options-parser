# Cop

[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat-square)](https://github.com/php-pds/skeleton)
![GitHub License](https://img.shields.io/github/license/phalcon/cli-options-parser)
![Codacy Grade](https://img.shields.io/codacy/grade/4064c9bc35634505852e41aedaa9386c)
![Codacy Code Coverage](https://img.shields.io/codacy/coverage/4064c9bc35634505852e41aedaa9386c)
![Downloads](https://img.shields.io/packagist/dm/phalcon/cli-options-parser)

Command line arguments/options parser.

## Requirements

*   PHP >= 8.0

## Installing via [Composer](https://getcomposer.org)

Install composer in a common location or in your project:

```bash
composer require phalcon/cli-options-parser
```

## Usage

```php
use Phalcon\Cop\Parser;

$parser = new Parser();

// Parse params from the $argv
$params = $parser->parse($argv);

// Parse params from the $_SERVER['argv']
$params = $parser->parse();

// After parsing input, Parser provides a way to gets booleans:
$parser->getBoolean('foo');

// Get param `foo` or return TRUE as a default value
$parser->getBoolean('foo', true);
```

### Examples

```
php test.php -az value1 -abc value2
[
    'a' => 'value2',
    'z' => 'value1',
    'b' => 'value2',
    'c' => 'value2',
]

php test.php -a value1 -abc value2
[
    'a'  => 'value2',
    'b'  => 'value2',
    'c'  => 'value2',
]

php test.php --az value1 --abc value2
[
    'az'  => 'value1',
    'abc' => 'value2',
]

php test.php --foo --bar=baz --spam eggs
[
    'foo'  => true,
    'bar'  => 'baz',
    'spam' => 'eggs',
]

php test.php -abc foo
[
    'a' => 'foo',
    'b' => 'foo',
    'c' => 'foo',
]

php test.php arg1 arg2 arg3
[
    0 => 'arg1',
    1 => 'arg2',
    2 => 'arg3',
]

php test.php \
    plain-arg \
    --foo \
    --bar=baz \
    --funny="spam=eggs" \
    --also-funny=spam=eggs \
    'plain arg 2'
    -abc \
    -k=value \
    "plain arg 3" \
    --s="original" \
    --s='overwrite' \
    --s
[
    0            => 'plain-arg',
    'foo'        => true,
    'bar'        => 'baz',
    'funny'      => 'spam=eggs',
    'also-funny' => 'spam=eggs',
    1            => 'plain arg 2',
    'a'          => true,
    'b'          => true,
    'c'          => true,
    'k'          => 'value',
    2            => 'plain arg 3',
    's'          => 'overwrite',
]
```

## License

The Cop is open source software licensed under the [MIT License](https://github.com/phalcon/cli-options-parser/blob/master/LICENSE).

© Phalcon Team
