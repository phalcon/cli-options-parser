<?php

/*
  +------------------------------------------------------------------------+
  | Phalcon Cli option parser                                              |
  +------------------------------------------------------------------------+
  | Copyright (c) 2011-present Phalcon Team (https://www.phalconphp.com)   |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Authors: Sergii Svyrydenko <sergey.v.sviridenko@gmail.com>             |
  +------------------------------------------------------------------------+
*/

return [
    [//test: -az value1 -abc value2
        'params' => [
            'command' => [
                '/usr/bin/phalcon',
                '-az',
                'value1',
                '-abc',
                'value2',
            ],
        ],
        'expect' => [
            'a' => 'value2',
            'z' => 'value1',
            'b' => 'value2',
            'c' => 'value2',
        ],
    ],
    [//test: -a value1 -abc value2
        'params' => [
            'command' => [
                '/usr/bin/phalcon',
                '-a',
                'value1',
                '-abc',
                'value2',
            ],
        ],
        'expect'  => [
            'a'  => 'value2',
            'b'  => 'value2',
            'c'  => 'value2',
        ],
    ],
    [//test: --az value1 --abc value2
        'params' => [
            'command' => [
                '/usr/bin/phalcon',
                '--az',
                'value1',
                '--abc',
                'value2',
            ],
        ],
        'expect'  => [
            'az'  => 'value1',
            'abc' => 'value2',
        ],
    ],
    [//test: --foo --bar=baz --spam eggs
        'params' => [
            'command' => [
                '/usr/bin/phalcon',
                '--foo',
                '--bar=baz',
                '--spam',
                'eggs',
            ],
        ],
        'expect' => [
            'foo'  => true,
            'bar'  => 'baz',
            'spam' => 'eggs',
        ],
    ],
    [//test: -abc foo
        'params' => [
            'command' => [
                '/usr/bin/phalcon',
                '-abc',
                'foo',
            ],
        ],
        'expect' => [
            'a' => 'foo',
            'b' => 'foo',
            'c' => 'foo',
        ],
    ],
    [//test: arg1 arg2 arg3
        'params' => [
            'command' => [
                '/usr/bin/phalcon',
                'arg1',
                'arg2',
                'arg3',
            ],
        ],
        'expect' => [
            0 => 'arg1',
            1 => 'arg2',
            2 => 'arg3',
        ],
    ],
    [//test: plain-arg --foo --bar=baz --funny="spam=eggs" --also-funny=spam=eggs 'plain arg 2' -abc -k=value "plain arg 3" --s="original" --s='overwrite' --s
        'params' => [
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
        'expect' => [
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
