# Phalcon - CLI Options Parser

[![CLI Options Parser CI][ci-badge]][ci-link]
[![Quality Gate Status][sonar-quality-badge]][sonar-link]
[![Coverage][sonar-coverage-badge]][sonar-link]
[![PDS Skeleton][pds-skeleton-badge]][pds-skeleton-link]
[![Downloads][downloads-badge]][downloads-link]

Command line arguments/options parser.

## Requirements

* PHP >= 8.0

## Installation

You can install the package using composer

```sh
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

// After parsing input, Parser provides a way to get booleans:
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
```

## Development

The repository ships a Docker setup for local development and testing. You only need Docker +
Docker Compose; the PHP runtime is provided inside the container.

### Quick start

```bash
docker compose up -d --build
docker compose exec app composer install
docker compose exec app composer test
```

> `app` is the Compose *service* name; the running container is `cli-options-parser-app`. It stays
> up via a `sleep infinity` keepalive, so you can `docker compose exec app <cmd>` freely.

### Choosing the PHP version

The image is built for one PHP version at a time via the `PHP_VERSION` build arg (default `8.4`;
supported `8.0`–`8.4`). Because it is a **build** arg, changing it requires a rebuild:

```bash
docker compose up -d --build                  # PHP 8.4 (default)
PHP_VERSION=8.0 docker compose up -d --build  # PHP 8.0
```

### Composer scripts

| Script | Description |
| --- | --- |
| `composer cs` | PHP_CodeSniffer (PSR-12) |
| `composer cs-fix` | Auto-fix coding-standard issues (phpcbf) |
| `composer cs-fixer` | PHP CS Fixer (dry-run) |
| `composer cs-fixer-fix` | Apply PHP CS Fixer |
| `composer analyze` | PHPStan static analysis (level max) |
| `composer test` | Unit tests (PHPUnit) |
| `composer test-coverage` | Tests + Clover coverage (`tests/_output/coverage.xml`) |

## License

CLI Options Parser is open source software licensed under the [BSD-3-Clause License](LICENSE).

© Phalcon Team

<!-- External links should be here -->
[ci-badge]:             https://github.com/phalcon/cli-options-parser/actions/workflows/main.yml/badge.svg?branch=master
[ci-link]:              https://github.com/phalcon/cli-options-parser/actions/workflows/main.yml
[sonar-quality-badge]:  https://sonarcloud.io/api/project_badges/measure?project=phalcon_cli-options-parser&metric=alert_status
[sonar-coverage-badge]: https://sonarcloud.io/api/project_badges/measure?project=phalcon_cli-options-parser&metric=coverage
[sonar-link]:           https://sonarcloud.io/summary/new_code?id=phalcon_cli-options-parser
[pds-skeleton-badge]:   https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat-square
[pds-skeleton-link]:    https://github.com/php-pds/skeleton
[downloads-badge]:      https://img.shields.io/packagist/dm/phalcon/cli-options-parser
[downloads-link]:       https://packagist.org/packages/phalcon/cli-options-parser
