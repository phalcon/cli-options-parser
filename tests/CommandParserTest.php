<?php

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

    public function parseProvider()
    {
        return include __DIR__ . '/fixtures/parse_parameters.php';
    }

    public function booleanProvider()
    {
        return include __DIR__ . '/fixtures/boolean_parameters.php';
    }
}
