<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$code = '1+2*3';

$lexer = new \BasicMaths\Lexer();
$parser = new \BasicMaths\Parser();
$interpreter = new \BasicMaths\Interpreter();
echo 'Result = ' . $interpreter($parser($lexer($code))) . "\n";
