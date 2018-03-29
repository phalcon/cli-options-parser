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
    [
        'params' => [
            'key' => 'key1',
            'default' => false,
            'argv' => [
                '/usr/bin/phalcon',
                '--key1',
                '1',
            ],
        ],
        'expect' => true,
    ],
    [
        'params' => [
            'key' => 'key2',
            'default' => true,
            'argv' => [
                '/usr/bin/phalcon',
                '--key2',
                '0',
            ],
        ],
        'expect' => false,
    ],
    [
        'params' => [
            'key' => 'key3',
            'default' => false,
            'argv' => [
                '/usr/bin/phalcon',
                '--key3',
                'y',
            ],
        ],
        'expect' => true,
    ],
    [
        'params' => [
            'key' => 'key4',
            'default' => true,
            'argv' => [
                '/usr/bin/phalcon',
                '--key4',
                'n',
            ],
        ],
        'expect' => false,
    ],
    [
        'params' => [
            'key' => 'key5',
            'default' => false,
            'argv' => [
                '/usr/bin/phalcon',
                '--key5',
                'yes',
            ],
        ],
        'expect' => true,
    ],
    [
        'params' => [
            'key' => 'key6',
            'default' => true,
            'argv' => [
                '/usr/bin/phalcon',
                '--key6',
                'no',
            ],
        ],
        'expect' => false,
    ],
    [
        'params' => [
            'key' => 'key7',
            'default' => false,
            'argv' => [
                '/usr/bin/phalcon',
                '--key7',
                'true',
            ],
        ],
        'expect' => true,
    ],
    [
        'params' => [
            'key' => 'key8',
            'default' => true,
            'argv' => [
                '/usr/bin/phalcon',
                '--key8',
                'false',
            ],
        ],
        'expect' => false,
    ],
    [
        'params' => [
            'key' => 'key9',
            'default' => false,
            'argv' => [
                '/usr/bin/phalcon',
                '--key9',
                'on',
            ],
        ],
        'expect' => true,
    ],
    [
        'params' => [
            'key' => 'key10',
            'default' => true,
            'argv' => [
                '/usr/bin/phalcon',
                '--key10',
                'off',
            ],
        ],
        'expect' => false,
    ],
    [
        'params' => [
            'key' => 'key11',
            'default' => false,
            'argv' => [
                '/usr/bin/phalcon',
                '--key11',
            ],
        ],
        'expect' => true,
    ],
    [//test default param
        'params' => [
            'key' => 'key13',
            'default' => false,
            'argv' => [
                '/usr/bin/phalcon',
                '--key12',
            ],
        ],
        'expect' => false,
    ],
];
