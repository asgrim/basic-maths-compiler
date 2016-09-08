<?php
declare(strict_types = 1);

namespace BasicMaths\Node\BinaryOp;

use BasicMaths\Node\NodeInterface;

abstract class AbstractBinaryOp implements NodeInterface
{
    /**
     * @var NodeInterface
     */
    private $left;

    /**
     * @var NodeInterface
     */
    private $right;

    public function __construct(NodeInterface $left, NodeInterface $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function getLeft() : NodeInterface
    {
        return $this->left;
    }

    public function getRight() : NodeInterface
    {
        return $this->right;
    }
}
