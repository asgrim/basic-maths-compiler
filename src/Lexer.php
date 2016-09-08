<?php
declare(strict_types = 1);

namespace BasicMaths;

final class Lexer
{
    private static $matches = [
        '/^(\+)/' => Token::T_ADD,
        '/^(-)/' => Token::T_SUBTRACT,
        '/^(\*)/' => Token::T_MULTIPLY,
        '/^(\/)/' => Token::T_DIVIDE,
        '/^(\d+)/' => Token::T_INTEGER,
        '/^(\s+)/' => Token::T_WHITESPACE,
    ];

    /**
     * @param string $input
     * @return Token[]
     */
    public function __invoke(string $input) : array
    {
        $tokens = [];

        $offset = 0;
        while ($offset < strlen($input)) {
            $focus = substr($input, $offset);
            $result = $this->match($focus);

            $tokens[] = $result;
            $offset += strlen($result->getLexeme());
        }

        return $tokens;
    }

    private function match(string $input) : Token
    {
        foreach (self::$matches as $pattern => $token) {
            if (preg_match($pattern, $input, $matches)) {
                return new Token($token, $matches[1]);
            }
        }

        throw new \RuntimeException(sprintf('Unmatched token, next 15 chars were: %s', substr($input, 0, 15)));
    }
}
