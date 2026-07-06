<?php

declare(strict_types=1);

namespace Phalcon\Cop\Tests\Unit\Parser;

use Phalcon\Cop\Parser;
use Phalcon\Cop\Tests\Support\Traits\ParserDataTrait;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

final class GetBooleanTest extends TestCase
{
    use ParserDataTrait;

    private Parser $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testReturnsBoolWhenParsedValueIsBool(): void
    {
        // "--flag" with no value is stored as bool(true) -> is_bool() branch.
        $this->parser->parse(['/usr/bin/phalcon', '--flag']);

        $this->assertTrue($this->parser->getBoolean('flag'));
    }

    public function testReturnsBoolWhenParsedValueIsInt(): void
    {
        // parse() only ever stores strings or bool(true); the is_int() branch in
        // getBoolean() is defensive and unreachable via the public API, so seed an
        // int directly (no source change) to exercise it.
        $property = new ReflectionProperty(Parser::class, 'parsedCommands');
        $property->setAccessible(true);

        $property->setValue($this->parser, ['count' => 5]);
        $this->assertTrue($this->parser->getBoolean('count'));

        $property->setValue($this->parser, ['count' => 0]);
        $this->assertFalse($this->parser->getBoolean('count'));
    }

    public function testReturnsDefaultForUnrecognizedValue(): void
    {
        $this->parser->parse(['/usr/bin/phalcon', '--key', 'maybe']);

        $this->assertTrue($this->parser->getBoolean('key', true));
        $this->assertFalse($this->parser->getBoolean('key', false));
    }

    public function testReturnsDefaultWhenKeyMissing(): void
    {
        // No default argument -> the built-in `false` default is returned;
        // an explicit default is honored too.
        $this->assertFalse($this->parser->getBoolean('missing'));
        $this->assertTrue($this->parser->getBoolean('missing', true));
    }

    /**
     * @dataProvider booleanProvider
     *
     * @param array{key: string, default: bool, argv: array<int, string>} $params
     */
    public function testTransformsRecognizedValues(array $params, bool $expected): void
    {
        $this->parser->parse($params['argv']);

        $this->assertSame(
            $expected,
            $this->parser->getBoolean($params['key'], $params['default'])
        );
    }
}
