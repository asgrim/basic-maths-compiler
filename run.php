<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$code = '5 + 3';

$lexer = new \BasicMaths\Lexer();

var_dump($lexer($code));
