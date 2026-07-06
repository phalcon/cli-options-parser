<?php

declare(strict_types=1);

namespace Phalcon\Cop\Tests\Unit\Parser;

use Phalcon\Cop\Parser;
use Phalcon\Cop\Tests\Support\Traits\ParserDataTrait;
use PHPUnit\Framework\TestCase;

final class ParseTest extends TestCase
{
    use ParserDataTrait;

    private Parser $parser;

    /** @var array<int, string> */
    private array $serverArgvBackup = [];

    protected function setUp(): void
    {
        $this->parser           = new Parser();
        $this->serverArgvBackup = $_SERVER['argv'] ?? [];
    }

    protected function tearDown(): void
    {
        $_SERVER['argv'] = $this->serverArgvBackup;
    }

    public function testParsesArgvFromServerWhenNoArgumentGiven(): void
    {
        $_SERVER['argv'] = ['script.php', 'arg1', 'arg2', 'arg3'];

        $this->assertSame(['arg1', 'arg2', 'arg3'], $this->parser->parse());
    }

    /**
     * @dataProvider parseProvider
     *
     * @param array{command: array<int, string>} $params
     * @param array<array-key, mixed>            $expected
     */
    public function testParsesCliCommand(array $params, array $expected): void
    {
        $this->assertSame($expected, $this->parser->parse($params['command']));
    }

    public function testParsesSingleDashClusterAsLastToken(): void
    {
        // A "-abc" cluster with no following token: every letter becomes true.
        // Guards the `$i + 1 < $j` boundary in handleArguments().
        $this->assertSame(
            ['a' => true, 'b' => true, 'c' => true],
            $this->parser->parse(['/usr/bin/phalcon', '-abc'])
        );
    }

    public function testReturnsEmptyArrayWhenServerArgvMissing(): void
    {
        unset($_SERVER['argv']);

        $this->assertSame([], $this->parser->parse());
    }
}
