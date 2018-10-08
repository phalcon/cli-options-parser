<?php

/**
 * This file is part of the Cop package.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phalcon\Cop;

/**
 * Phalcon\Cop\Parser
 *
 * @package Phalcon\Cop
 */
class Parser
{
    /** @var array */
    private $parsedCommands;

    /** @var array */
    private $boolParamSet = [
        'y'     => true,
        'n'     => false,
        'yes'   => true,
        'no'    => false,
        'true'  => true,
        'false' => false,
        '1'     => true,
        '0'     => false,
        'on'    => true,
        'off'   => false,
    ];

    /**
     * Parse console input.
     *
     * @param  array $argv
     * @return array
     */
    public function parse(array $argv = []): array
    {
        if (empty($argv)) {
            $argv = $this->getArgvFromServer();
        }

        array_shift($argv);
        $this->parsedCommands = [];

        return $this->handleArguments($argv);
    }

    /**
     * Get boolean from parsed parameters.
     *
     * @param  string $key
     * @param  bool $default
     * @return bool
     */
    public function getBoolean(string $key, bool $default = false): bool
    {
        if (!isset($this->parsedCommands[$key])) {
            return $default;
        }

        if (is_bool($this->parsedCommands[$key]) || is_int($this->parsedCommands[$key])) {
            return (bool)$this->parsedCommands[$key];
        }

        return $this->getCoalescingDefaul($this->parsedCommands[$key], $default);
    }

    /**
     * Gets array of arguments passed from the input.
     *
     * @return array
     */
    protected function getArgvFromServer(): array
    {
        return empty($_SERVER['argv']) ? [] : $_SERVER['argv'];
    }

    /**
     * Handle received parameters
     *
     * @param array $argv
     * @return array
     */
    protected function handleArguments(array $argv): array
    {
        for ($i = 0, $j = count($argv); $i < $j; $i++) {
            // --foo --bar=baz
            if (substr($argv[$i], 0, 2) === '--') {
                if ($this->parseAndMergeCommandWithEqualSign($argv[$i])) {// --bar=baz
                    continue;
                }

                $key = $this->stripSlashes($argv[$i]);
                if ($i + 1 < $j && $argv[$i + 1][0] !== '-') {// --foo value
                    $this->parsedCommands[$key] = $argv[$i + 1];
                    $i++;
                    continue;
                }
                $this->parsedCommands[$key] = $this->parsedCommands[$key] ?? true; // --foo
                continue;
            }

            // -k=value -abc
            if (substr($argv[$i], 0, 1) === '-') {
                if ($this->parseAndMergeCommandWithEqualSign($argv[$i])) {// -k=value
                    continue;
                }

                // -a value1 -abc value2 -abc
                $hasNextElementDash = $i + 1 < $j && $argv[$i + 1][0] !== '-' ? false : true;
                foreach (str_split(substr($argv[$i], 1)) as $char) {
                    $this->parsedCommands[$char] = $hasNextElementDash ? true : $argv[$i + 1];
                }

                if (!$hasNextElementDash) {// -a value1 -abc value2
                    $i++;
                }
                continue;
            }

            $this->parsedCommands[] = $argv[$i];
        }

        return $this->parsedCommands;
    }

    /**
     * Delete dashes from param
     *
     * @param string $argument
     * @return string
     */
    protected function stripSlashes(string $argument): string
    {
        if (substr($argument, 0, 1) !== '-') {
            return $argument;
        }

        $argument = substr($argument, 1);

        return $this->stripSlashes($argument);
    }

    /**
     * Return either received parameter or default
     *
     * @param string $value
     * @param bool $default
     * @return bool
     */
    protected function getCoalescingDefaul(string $value, bool $default): bool
    {
        return $this->boolParamSet[$value] ?? $default;
    }

    /**
     * Parse command `foo=bar`
     *
     * @param string $command
     * @return bool
     */
    protected function parseAndMergeCommandWithEqualSign(string $command): bool
    {
        if (($eqPos = strpos($command, '=')) !== false) {
            $this->parsedCommands = array_merge($this->parsedCommands, $this->getParamWithEqual($command, $eqPos));

            return true;
        }

        return false;
    }

    /**
     * @param string $arg
     * @param int $eqPos
     * @return array
     */
    protected function getParamWithEqual(string $arg, int $eqPos): array
    {
        $key       = $this->stripSlashes(substr($arg, 0, $eqPos));
        $out[$key] = substr($arg, $eqPos +1);

        return $out;
    }
}
