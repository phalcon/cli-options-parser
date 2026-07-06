<?php

declare(strict_types=1);

namespace Phalcon\Cop\Tests\Unit\Parser;

use Phalcon\Cop\Parser;
use PHPUnit\Framework\TestCase;

final class HasTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testReturnsFalseWhenKeyMissing(): void
    {
        $this->assertFalse($this->parser->has('missing'));

        $this->parser->parse(['/usr/bin/phalcon', '--foo', 'bar']);
        $this->assertFalse($this->parser->has('missing'));
    }

    public function testReturnsTrueForIntegerIndexedPlainArg(): void
    {
        $this->parser->parse(['/usr/bin/phalcon', 'arg1']);

        $this->assertTrue($this->parser->has(0));
    }

    public function testReturnsTrueForNamedKey(): void
    {
        $this->parser->parse(['/usr/bin/phalcon', '--foo', 'bar']);

        $this->assertTrue($this->parser->has('foo'));
    }
}
