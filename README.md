# CLI Options Parser


[![Software License](https://img.shields.io/badge/license-BSD--3-brightgreen.svg?style=flat-square)][:license:]
[![Build Status](https://travis-ci.org/phalcon/cli-options-parser.svg?branch=master)](https://travis-ci.org/phalcon/cli-options-parser)

Command line arguments parser.

## Requirements

* PHP >= 7.0
* Phalcon >= 3.3.*

## Installing via [Composer](https://getcomposer.org)

Install composer in a common location or in your project:

```bash
curl -s http://getcomposer.org/installer | php
```

Create the composer.json file as follows:

```json
{
    "require": {
        "phalcon/cli-options-parser": "@stable"
    }
}
```

Run the composer installer:

```bash
php composer.phar install
```

## Installation via Git

CLI Options Parser can be installed by using Git.

Just clone the repo and checkout the current branch:

```bash
git clone https://github.com/phalcon/cli-options-parser.git
```

## Usage

```php
use Phalcon\Cop\Parser

$parser = new Parser();

// Handle params from $argv
$params = $parser->parse($argv);

// Handle params from $_SERVER
$params = $parser->parse();

// After handle params, CommandParser provides boolean params via key:
// Get param if exist or return false as default value
$parser->getBoolean('foo');

Get param if exist or return true as default value
$parser->getBoolean('foo', true);
```

## Example

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

CLI Options parser is open source software licensed under the [New BSD License][:license:].<br>
© Phalcon Team and contributors

[:license:]: https://github.com/phalcon/cli-options-parser/blob/master/LICENSE.txt
