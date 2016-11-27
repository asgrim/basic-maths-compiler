<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$code = '1+2*3';

$lexer = new \BasicMaths\Lexer();
$parser = new \BasicMaths\Parser();
$compiler = new \BasicMaths\CompileToAsm();
file_put_contents('tmp.asm', $compiler($parser($lexer($code))));
exec('nasm -f elf64 -F dwarf -g tmp.asm');
exec('ld -dynamic-linker /lib64/ld-linux-x86-64.so.2 -o basic-maths tmp.o -lc');
unlink('tmp.o');
unlink('tmp.asm');
echo "Compilation complete. You can now run ./basic-maths\n";
