<?php
declare(strict_types = 1);

namespace BasicMaths;

use BasicMaths\Node\NodeInterface;

final class Interpreter
{
    public function __invoke(NodeInterface $node)
    {
        return $this->compileNode($node);
    }

    private function compileNode(NodeInterface $node)
    {
        if ($node instanceof Node\BinaryOp\AbstractBinaryOp) {
            return $this->compileBinaryOp($node);
        }

        if ($node instanceof Node\Scalar\IntegerValue) {
            return $node->getValue();
        }
    }

    private function compileBinaryOp(Node\BinaryOp\AbstractBinaryOp $node)
    {
        $left = $this->compileNode($node->getLeft());
        $right = $this->compileNode($node->getRight());

        switch (get_class($node)) {
            case Node\BinaryOp\Add::class:
                return $left + $right;
            case Node\BinaryOp\Subtract::class:
                return $left - $right;
            case Node\BinaryOp\Multiply::class:
                return $left * $right;
            case Node\BinaryOp\Divide::class:
                return $left / $right;
        }
        throw new \InvalidArgumentException(sprintf('Unknown binary operator: %s', get_class($node)));
    }
}
