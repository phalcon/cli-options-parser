<?php

/**
 * This file is part of the Cop package.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Cop\Tests;

use Phalcon\Cop\Parser;
use PHPUnit\Framework\TestCase;
use stdClass;

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
    public function setUp(): void
    {
        $this->parser = new Parser();
    }

    /**
     * @test
     * @dataProvider parseProvider
     *
     * @param array $params
     * @param array $expected
     */
    public function shouldParseCliCommand(array $params, array $expected): void
    {
        $actual = $this->parser->parse($params['command']);
        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function shouldParseCommandFromTheServer(): void
    {
        $_SERVER['argv'] = ['script.php', 'arg1', 'arg2', 'arg3'];

        $expected = ['arg1', 'arg2', 'arg3'];
        $actual   = $this->parser->parse();
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @dataProvider booleanProvider
     *
     * @param array $params
     * @param bool  $expected
     */
    public function shouldTransformParamsToBool(array $params, bool $expected): void
    {
        $this->parser->parse($params['argv']);

        $actual = $this->parser->getBoolean($params['key'], $params['default']);
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @return void
     */
    public function testGetParsedCommandsShouldReturnEmptyArrayOnNewObject(): void
    {
        $parser = new Parser();
        $actual = $parser->getParsedCommands();
        $this->assertEmpty(
            $actual,
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
    public function testGetParsedCommandsShouldReturnParsedCommand(
        array $params,
        array $expected
    ): void {
        $this->parser->parse($params["command"]);

        $actual = $this->parser->getParsedCommands();
        $this->assertSame(
            $expected,
            $actual,
            "Parsed commands should be returned."
        );

        $this->parser->parse(["script-with-no-parameters"]);
        $actual = $this->parser->getParsedCommands();
        $this->assertEmpty(
            $actual,
            "Parser state should be modified absolutely, 
            if overridden by another parse call."
        );

        $this->parser->parse($params["command"]);
        $actual = $this->parser->getParsedCommands();
        $this->assertSame(
            $expected,
            $actual,
            "Parsed commands should be returned after re-parsing original command."
        );
    }

    /**
     * @test
     * @dataProvider parseProvider
     *
     * @param array $params
     * @param array $expect
     */
    public function testGetReturnsBoundDefaultValueIfNotSet(
        array $params,
        array $expect
    ): void {
        $expectedDefaultValues = [
            123,
            "test",
            12.3,
            true,
            new stdClass(),
        ];

        $nonExistingParameterKey = "non-existing-parameter-key";

        foreach ($expectedDefaultValues as $expectedDefaultValue) {
            $actual = $this->parser->get($nonExistingParameterKey, $expectedDefaultValue);
            $this->assertSame(
                $expectedDefaultValue,
                $actual,
                "Should return the provided default value, 
                if the queried parameter doesn't exist in an empty/fresh object."
            );
        }

        $this->parser->parse($params["command"]);

        foreach ($expectedDefaultValues as $expectedDefaultValue) {
            $actual = $this->parser->get($nonExistingParameterKey, $expectedDefaultValue);
            $this->assertSame(
                $expectedDefaultValue,
                $actual,
                "Should return null, 
                if the queried parameter doesn't exist in a populated/parsed object."
            );
        }
    }

    /**
     * @test
     * @dataProvider parseProvider
     *
     * @param array $params
     * @param array $expect
     */
    public function testGetReturnsNullIfParamDoesNotExist(array $params): void
    {
        $nonExistingParameterKey = "non-existing-parameter-key";
        $actual = $this->parser->get($nonExistingParameterKey);
        $this->assertNull(
            $actual,
            "Should return null,
            if the queried parameter doesn't exist in an empty/fresh object."
        );

        $this->parser->parse($params["command"]);
        $actual = $this->parser->get($nonExistingParameterKey);
        $this->assertNull(
            $actual,
            "Should return null,
            if the queried parameter doesn't exist in a populated/parsed object."
        );
    }

    /**
     * @test
     * @dataProvider parseProvider
     *
     * @param array $params
     * @param array $expected
     */
    public function testGetReturnsValueIfParamDoesExist(array $params, array $expected)
    {
        $this->parser->parse($params["command"]);
        foreach ($expected as $parameterKey => $expectedValue) {
            $actual = $this->parser->get($parameterKey);
            $this->assertEquals(
                $expectedValue,
                $actual,
                "It's expected to have the value returned untouched."
            );
        }
    }

    /**
     * @return array
     */
    public function booleanProvider(): array
    {
        return include __DIR__ . '/fixtures/boolean_parameters.php';
    }

    /**
     * @return mixed
     */
    public function parseProvider(): array
    {
        return include __DIR__ . '/fixtures/parse_parameters.php';
    }
}
