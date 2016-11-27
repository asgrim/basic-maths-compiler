<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$code = '5 + 50';

$lexer = new \BasicMaths\Lexer();
$parser = new \BasicMaths\Parser();

// Interpret mode:
//$interpreter = new \BasicMaths\Interpreter();
//echo 'Interpreter result = ' . $interpreter($parser($lexer($code))) . "\n";

// Compile mode:
$compiler = new \BasicMaths\CompileToAsm();
file_put_contents('tmp.asm', $compiler($parser($lexer($code))));
exec('nasm -f elf64 -F dwarf -g tmp.asm');
exec('ld -dynamic-linker /lib64/ld-linux-x86-64.so.2 -o basic-maths tmp.o -lc');
unlink('tmp.o');
unlink('tmp.asm');
