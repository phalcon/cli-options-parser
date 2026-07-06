<?php

declare(strict_types=1);

namespace Phalcon\Cop\Tests\Unit\Parser;

use Phalcon\Cop\Parser;
use Phalcon\Cop\Tests\Support\Traits\ParserDataTrait;
use PHPUnit\Framework\TestCase;
use stdClass;

final class GetTest extends TestCase
{
    use ParserDataTrait;

    private Parser $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testReturnsDefaultWhenParamMissing(): void
    {
        $key      = 'non-existing-parameter-key';
        $defaults = [123, 'test', 12.3, true, new stdClass()];

        foreach ($defaults as $default) {
            $this->assertSame($default, $this->parser->get($key, $default));
        }

        $this->parser->parse(['/usr/bin/phalcon', '--foo', 'bar']);
        foreach ($defaults as $default) {
            $this->assertSame($default, $this->parser->get($key, $default));
        }
    }

    public function testReturnsNullWhenParamMissing(): void
    {
        $key = 'non-existing-parameter-key';

        $this->assertNull($this->parser->get($key));

        $this->parser->parse(['/usr/bin/phalcon', '--foo', 'bar']);
        $this->assertNull($this->parser->get($key));
    }

    /**
     * @dataProvider parseProvider
     *
     * @param array{command: array<int, string>} $params
     * @param array<array-key, mixed>            $expected
     */
    public function testReturnsValueWhenParamExists(array $params, array $expected): void
    {
        $this->parser->parse($params['command']);

        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $this->parser->get($key));
        }
    }
}
