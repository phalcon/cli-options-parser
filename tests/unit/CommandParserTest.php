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

namespace Phalcon\Cli\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phalcon\Cli\Parser\CommandParser;

/**
 * Phalcon\Cli\Tests\Unit\CommandParserTest
 *
 * @package Phalcon\Cli\Tests\Unit
 */
class CommandParserTest extends TestCase
{
    /** @var CommandParser */
    protected $parser;

    /**
     * @before
     */
    protected function initParserObject()
    {
        $this->parser = new CommandParser();
    }

    /**
     * Tests CommandParser::parse
     *
     * @test
     * @issue  -
     * @author Sergii Svyrydenko <sergey.v.sviridenko@gmail.com>
     * @since  2018-03-29
     *
     * @dataProvider parseProvider
     */
    public function shouldParseCliCommand($params, $expect)
    {
        $this->assertEquals($expect, $this->parser->parse($params['command']));
    }

    /**
     * Tests CommandParser::getBoolean
     *
     * @test
     * @issue  -
     * @author Sergii Svyrydenko <sergey.v.sviridenko@gmail.com>
     * @since  2018-03-29
     *
     * @dataProvider booleanProvider
     */
    public function shouldTransformeParamToBool($params, $expect)
    {
        $this->parser->parse($params['argv']);

        $this->assertEquals($expect, $this->parser->getBoolean($params['key'], $params['default']));
    }

    /**
     * Provider for test shouldParseCliCommand
     */
    public function parseProvider()
    {
        return include PATH_FIXTURES . 'command_parser_test/parse_parameters.php';
    }

    /**
     * Provider for test shouldTransformeParamToBool
     */
    public function booleanProvider()
    {
        return include PATH_FIXTURES . 'command_parser_test/boolean_parameters.php';
    }
}
