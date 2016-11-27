# Basic Maths Interpreter

A very basic lexer/parser/compiler combination that evaluates very simple mathematical expressions.

The only operations available are:

 - Add `+`
 - Subtract `-`
 - Multiply `*`
 - Divide `/`
 
You can only calculate using positive integers. Whitespace is ignored, but the program only expects a single line of
input (will result in an error like `Did not resolve stack down to single value`).

## Usage

```
$ git clone <url>
$ cd <folder>
$ composer install
$ php run.php
```

You can edit the code to be executed in `run.php` to see different results.
