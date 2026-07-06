<?php

declare(strict_types=1);

namespace Phalcon\Cop\Tests\Support\Traits;

trait ParserDataTrait
{
    /**
     * @return array<int, array{params: array{command: array<int, string>}, expected: array<array-key, mixed>}>
     */
    public static function parseProvider(): array
    {
        return [
            // -az value1 -abc value2
            [
                'params'   => ['command' => ['/usr/bin/phalcon', '-az', 'value1', '-abc', 'value2']],
                'expected' => ['a' => 'value2', 'z' => 'value1', 'b' => 'value2', 'c' => 'value2'],
            ],
            // -a value1 -abc value2
            [
                'params'   => ['command' => ['/usr/bin/phalcon', '-a', 'value1', '-abc', 'value2']],
                'expected' => ['a' => 'value2', 'b' => 'value2', 'c' => 'value2'],
            ],
            // --az value1 --abc value2
            [
                'params'   => ['command' => ['/usr/bin/phalcon', '--az', 'value1', '--abc', 'value2']],
                'expected' => ['az' => 'value1', 'abc' => 'value2'],
            ],
            // --foo --bar=baz --spam eggs
            [
                'params'   => ['command' => ['/usr/bin/phalcon', '--foo', '--bar=baz', '--spam', 'eggs']],
                'expected' => ['foo' => true, 'bar' => 'baz', 'spam' => 'eggs'],
            ],
            // -abc foo
            [
                'params'   => ['command' => ['/usr/bin/phalcon', '-abc', 'foo']],
                'expected' => ['a' => 'foo', 'b' => 'foo', 'c' => 'foo'],
            ],
            // arg1 arg2 arg3
            [
                'params'   => ['command' => ['/usr/bin/phalcon', 'arg1', 'arg2', 'arg3']],
                'expected' => [0 => 'arg1', 1 => 'arg2', 2 => 'arg3'],
            ],
            // plain-arg --foo --bar=baz --funny=spam=eggs --also-funny=spam=eggs 'plain arg 2'
            // -abc -k=value 'plain arg 3' --s=original --s=overwrite --s
            [
                'params'   => [
                    'command' => [
                        '/usr/bin/phalcon',
                        'plain-arg',
                        '--foo',
                        '--bar=baz',
                        '--funny=spam=eggs',
                        '--also-funny=spam=eggs',
                        'plain arg 2',
                        '-abc',
                        '-k=value',
                        'plain arg 3',
                        '--s=original',
                        '--s=overwrite',
                        '--s',
                    ],
                ],
                'expected' => [
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
                ],
            ],
        ];
    }

    /**
     * @return array<int, array{params: array{key: string, default: bool, argv: array<int, string>}, expected: bool}>
     */
    public static function booleanProvider(): array
    {
        return [
            ['params' => ['key' => 'key1', 'default' => false, 'argv' => ['/usr/bin/phalcon', '--key1', '1']], 'expected' => true],
            ['params' => ['key' => 'key2', 'default' => true, 'argv' => ['/usr/bin/phalcon', '--key2', '0']], 'expected' => false],
            ['params' => ['key' => 'key3', 'default' => false, 'argv' => ['/usr/bin/phalcon', '--key3', 'y']], 'expected' => true],
            ['params' => ['key' => 'key4', 'default' => true, 'argv' => ['/usr/bin/phalcon', '--key4', 'n']], 'expected' => false],
            ['params' => ['key' => 'key5', 'default' => false, 'argv' => ['/usr/bin/phalcon', '--key5', 'yes']], 'expected' => true],
            ['params' => ['key' => 'key6', 'default' => true, 'argv' => ['/usr/bin/phalcon', '--key6', 'no']], 'expected' => false],
            ['params' => ['key' => 'key7', 'default' => false, 'argv' => ['/usr/bin/phalcon', '--key7', 'true']], 'expected' => true],
            ['params' => ['key' => 'key8', 'default' => true, 'argv' => ['/usr/bin/phalcon', '--key8', 'false']], 'expected' => false],
            ['params' => ['key' => 'key9', 'default' => false, 'argv' => ['/usr/bin/phalcon', '--key9', 'on']], 'expected' => true],
            ['params' => ['key' => 'key10', 'default' => true, 'argv' => ['/usr/bin/phalcon', '--key10', 'off']], 'expected' => false],
            // --key11 with no value -> stored as bool true -> is_bool branch
            ['params' => ['key' => 'key11', 'default' => false, 'argv' => ['/usr/bin/phalcon', '--key11']], 'expected' => true],
            // querying an absent key returns the default
            ['params' => ['key' => 'key13', 'default' => false, 'argv' => ['/usr/bin/phalcon', '--key12']], 'expected' => false],
        ];
    }
}
