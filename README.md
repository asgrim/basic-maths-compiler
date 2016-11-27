# Basic Maths Language

A very basic lexer/parser that evaluates very simple mathematical expressions.

The only operations available are:

 - Add `+`
 - Subtract `-`
 - Multiply `*`
 - Divide `/`
 
You can only calculate using positive integers. Whitespace is ignored, but the program only expects a single line of
input (will result in an error like `Did not resolve stack down to single value`).

The result of the parser is an AST which can be fed into an included interpreter or compiler.

## Setup

```
$ git clone <url>
$ cd <folder>
$ composer install
```

## Interpreter mode

To use the interpreter, you can run `interpret.php`

```
$ php interpret.php
Result = 7
```

You can edit the code to be executed in `interpret.php` to see different results. The interpreter is essentially a tiny
virtual machine that executes the AST directly.

## Compiled mode

To use the compiler, you can run `compile.php` then execute the resulting binary:

```
$ php compile.php
Compilation complete. You can now run ./basic-maths
$ ./basic-maths
Result = 7
```

Note, this will very likely only work on a 64-bit Linux system. The compiler works by naively generating assembly code
then using `nasm` and then linking with `ld`. It works for me, but YMMV...
