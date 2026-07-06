<?php

declare(strict_types=1);

namespace Phalcon\Cop\Tests\Unit\Parser;

use Phalcon\Cop\Parser;
use Phalcon\Cop\Tests\Support\Traits\ParserDataTrait;
use PHPUnit\Framework\TestCase;

final class GetParsedCommandsTest extends TestCase
{
    use ParserDataTrait;

    private Parser $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testReturnsEmptyArrayOnFreshObject(): void
    {
        $this->assertSame([], (new Parser())->getParsedCommands());
    }

    /**
     * @dataProvider parseProvider
     *
     * @param array{command: array<int, string>} $params
     * @param array<array-key, mixed>            $expected
     */
    public function testReturnsParsedCommandsAndResetsBetweenParses(
        array $params,
        array $expected
    ): void {
        $this->parser->parse($params['command']);
        $this->assertSame($expected, $this->parser->getParsedCommands());

        // A subsequent parse replaces state completely.
        $this->parser->parse(['script-with-no-parameters']);
        $this->assertSame([], $this->parser->getParsedCommands());

        // Re-parsing the original command restores the original result.
        $this->parser->parse($params['command']);
        $this->assertSame($expected, $this->parser->getParsedCommands());
    }
}
