<?php
declare(strict_types = 1);

namespace BasicMaths;

final class Token
{
    const T_ADD = 'T_ADD';
    const T_SUBTRACT = 'T_SUBTRACT';
    const T_MULTIPLY = 'T_MULTIPLY';
    const T_DIVIDE = 'T_DIVIDE';
    const T_INTEGER = 'T_INTEGER';
    const T_WHITESPACE = 'T_WHITESPACE';

    private static $validTokens = [
        self::T_ADD,
        self::T_SUBTRACT,
        self::T_MULTIPLY,
        self::T_DIVIDE,
        self::T_INTEGER,
        self::T_WHITESPACE,
    ];

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $lexeme;

    public function __construct(string $token, string $lexeme)
    {
        if (!in_array($token, self::$validTokens, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid token: %d', $token));
        }

        $this->token = $token;
        $this->lexeme = $lexeme;
    }

    public function getToken() : string
    {
        return $this->token;
    }

    public function getLexeme() : string
    {
        return $this->lexeme;
    }

    public function isOperator() : bool
    {
        return in_array($this->token, [
            self::T_ADD,
            self::T_SUBTRACT,
            self::T_MULTIPLY,
            self::T_DIVIDE,
        ], true);
    }
}
