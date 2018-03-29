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

namespace Phalcon\Cli\Parser;

/**
 * Phalcon\Cli\Parser\CommandParser
 *
 * @package Phalcon\Cli\Parser
 */
class CommandParser
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
     * Parse CLI command
     *
     * @param array $argv
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
     * Get console command either from argument or from Server
     *
     * @return array
     * @throws Exception
     */
    protected function getArgvFromServer(): array
    {
        if (!empty($_SERVER['argv'])) {
            return $_SERVER['argv'];
        }

        throw new Exception("Parameters haven't been defined yet");
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
