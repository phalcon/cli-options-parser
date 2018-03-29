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

error_reporting(-1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
setlocale(LC_ALL, 'en_US.utf-8');

date_default_timezone_set('UTC');

clearstatcache();

$root = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR;

defined('TESTS_PATH')   || define('TESTS_PATH', $root);
defined('PROJECT_PATH') || define('PROJECT_PATH', dirname(TESTS_PATH) . DIRECTORY_SEPARATOR);
defined('PATH_FIXTURES')|| define('PATH_FIXTURES', $root .  '_fixtures' . DIRECTORY_SEPARATOR);

unset($root);

require_once PROJECT_PATH . 'vendor/autoload.php';

if (extension_loaded('xdebug')) {
    ini_set('xdebug.cli_color', 1);
    ini_set('xdebug.collect_params', 0);
    ini_set('xdebug.dump_globals', 'on');
    ini_set('xdebug.show_local_vars', 'on');
    ini_set('xdebug.max_nesting_level', 100);
    ini_set('xdebug.var_display_max_depth', 4);
}
