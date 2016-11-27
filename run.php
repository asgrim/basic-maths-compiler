<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$code = '5+2';

$lexer = new \BasicMaths\Lexer();
$parser = new \BasicMaths\Parser();

// Interpret mode:
//$interpreter = new \BasicMaths\Interpreter();
//var_dump($interpreter($parser($lexer($code))));
