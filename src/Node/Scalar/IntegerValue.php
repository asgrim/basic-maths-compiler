<?php
declare(strict_types = 1);

namespace BasicMaths\Node\Scalar;

use BasicMaths\Node\NodeInterface;

final class IntegerValue implements NodeInterface
{
    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue() : int
    {
        return $this->value;
    }
}
