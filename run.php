<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$code = "5+2\n3+2";

$lexer = new \BasicMaths\Lexer();
$parser = new \BasicMaths\Parser();
$compiler = new \BasicMaths\Compiler();

var_dump($compiler($parser($lexer($code))));
