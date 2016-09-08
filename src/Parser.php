<?php
declare(strict_types = 1);

namespace BasicMaths;

use BasicMaths\Node\NodeInterface;
use InvalidArgumentException;
use RuntimeException;

final class Parser
{
    /**
     * Higher number is higher precedence.
     * @var int[]
     */
    private static $operatorPrecedence = [
        Token::T_SUBTRACT => 0,
        Token::T_ADD => 1,
        Token::T_DIVIDE => 2,
        Token::T_MULTIPLY => 3,
    ];

    public function __invoke(array $tokens)
    {
        return $this->createAst($this->reorderTokensToReversePolish($tokens));
    }

    /**
     * @param Token[] $tokens
     * @return Token[]
     * @throws \InvalidArgumentException
     */
    private function reorderTokensToReversePolish(array $tokens) : array
    {
        /** @var Token[] $stack */
        $stack = [];
        /** @var Token[] $operators */
        $operators = [];

        while (false !== ($token = current($tokens))) {
            if (!$token instanceof Token) {
                throw new InvalidArgumentException(sprintf('Expected token, got: %s', gettype($token)));
            }

            // Whitespace is dropped, it does not matter to us, so we can ignore it from now on
            if ($token->getToken() === Token::T_WHITESPACE) {
                next($tokens);
                continue;
            }

            if ($token->isOperator()) {
                $tokenPrecedence = self::$operatorPrecedence[$token->getToken()];

                // This will go through the operator stack to find those with a higher precedence. If one is found, it
                // will be pushed onto the token stack, thus operating on the correct operands
                while (count($operators)
                    && self::$operatorPrecedence[$operators[count($operators) - 1]->getToken()] > $tokenPrecedence
                ) {
                    $higherOp = array_pop($operators);
                    $stack[] = $higherOp;
                }

                $operators[] = $token;
                next($tokens);
                continue;
            }

            // Anything that isn't a handled above is simply pushed onto the new token stack
            $stack[] = $token;

            next($tokens);
        }

        // Clean up by moving any remaining operators onto the token stack
        while (count($operators)) {
            $stack[] = array_pop($operators);
        }

        return $stack;
    }

    /**
     * @param Token[] $tokenStack
     * @return NodeInterface
     * @throws RuntimeException
     */
    private function createAst(array $tokenStack) : NodeInterface
    {
        $astStack = [];
        $ip = 0; // Instruction Pointer

        while ($ip < count($tokenStack)) {
            $token = $tokenStack[$ip++];

            if ($token->isOperator()) {
                switch ($token->getToken()) {
                    case Token::T_ADD:
                        $nodeType = Node\BinaryOp\Add::class;
                        break;
                    case Token::T_SUBTRACT:
                        $nodeType = Node\BinaryOp\Subtract::class;
                        break;
                    case Token::T_DIVIDE:
                        $nodeType = Node\BinaryOp\Divide::class;
                        break;
                    case Token::T_MULTIPLY:
                        $nodeType = Node\BinaryOp\Multiply::class;
                        break;
                    default:
                        throw new RuntimeException(sprintf('Invalid operator %s', $token->getToken()));
                }
                $right = array_pop($astStack);
                $left = array_pop($astStack);
                $astStack[] = new $nodeType($left, $right);
                continue;
            }

            switch ($token->getToken()) {
                case Token::T_INTEGER:
                    $astStack[] = new Node\Scalar\IntegerValue((int)$token->getLexeme());
                    break;
                default:
                    throw new RuntimeException(sprintf('Unhandled token %s', $token->getToken()));
            }
        }

        if (count($astStack) !== 1) {
            throw new RuntimeException(sprintf('Did not resolve stack down to single value (%d items)', count($astStack)));
        }

        return reset($astStack);
    }
}
