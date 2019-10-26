<?php declare(strict_types=1);

/**
 * This file is part of the Cop package.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phalcon\Cop\Tests;

use Phalcon\Cop\Parser;
use PHPUnit\Framework\TestCase;

/**
 * Phalcon\Cop\Tests\ParserTest
 *
 * @package Phalcon\Cop\Tests
 */
class ParserTest extends TestCase
{
    /** @var Parser */
    protected $parser;

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function setUp()
    {
        $this->parser = new Parser();
    }

    /**
     * @test
     * @dataProvider parseProvider
     *
     * @param array $params
     * @param array $expect
     */
    public function shouldParseCliCommand($params, $expect)
    {
        $this->assertEquals($expect, $this->parser->parse($params['command']));
    }

    /** @test */
    public function shouldParseCommandFromTheServer()
    {
        $_SERVER['argv'] = ['script.php', 'arg1', 'arg2', 'arg3'];

        $this->assertEquals(['arg1', 'arg2', 'arg3'], $this->parser->parse());
    }

    /**
     * @test
     * @dataProvider booleanProvider
     *
     * @param array $params
     * @param bool  $expect
     */
    public function shouldTransformParamsToBool($params, $expect)
    {
        $this->parser->parse($params['argv']);

        $this->assertEquals($expect, $this->parser->getBoolean($params['key'], $params['default']));
    }

    public function testGetParsedCommands_shouldReturnAnEmptyArrayIfObjectIsFresh()
    {
        $parser = new Parser();
        $this->assertEmpty(
            $parser->getParsedCommands(),
            "It's expected to receive an empty array if no parsing has been done yet."
        );
    }

    /**
     * @test
     * @dataProvider parseProvider
     *
     * @param array $params
     * @param array $expect
     */
    public function testGetParsedCommands_shouldReturnParsedCommand(array $params, array $expect)
    {
        $this->parser->parse($params["command"]);
        $this->assertEquals(
            $expect,
            $this->parser->getParsedCommands(),
            "Parsed commands should be returned."
        );
        $this->parser->parse(["script-with-no-parameters"]);
        $this->assertEmpty(
            $this->parser->getParsedCommands(),
            "Parser state should be modified absolutely, if overridden by another parse call."
        );

        $this->parser->parse($params["command"]);
        $this->assertEquals(
            $expect,
            $this->parser->getParsedCommands(),
            "Parsed commands should be returned after re-parsing original command."
        );
    }

    public function parseProvider()
    {
        return include __DIR__ . '/fixtures/parse_parameters.php';
    }

    public function booleanProvider()
    {
        return include __DIR__ . '/fixtures/boolean_parameters.php';
    }
}
