<?php
declare(strict_types = 1);

namespace BasicMaths;

use BasicMaths\Node\NodeInterface;

final class CompileToAsm
{
    private $lines = [];

    public function __invoke(NodeInterface $node)
    {
        $this->lines = [
            'section .bss',
            '    result resb 2',
            'section .data',
            '    fmt db `Result = %i\n`, 0',
            'section .text',
            '    global _start',
            '    extern printf',
            '_start:',
        ];
        $this->compileNode($node);
        $this->lines[] = '    mov rdi, fmt';
        $this->lines[] = '    pop rsi';
        $this->lines[] = '    xor eax,eax';
        $this->lines[] = '    call printf';
        $this->lines[] = '    xor edi,edi';
        $this->lines[] = '    call exit';
        $this->lines[] = 'exit:';
        $this->lines[] = '    mov rax,1';
        $this->lines[] = '    mov rbx,0';
        $this->lines[] = '    int 80h';
        $this->lines[] = 'message db "Result = %i", 10, 0';

        return implode("\n", $this->lines);
    }

    private function compileNode(NodeInterface $node)
    {
        if ($node instanceof Node\BinaryOp\AbstractBinaryOp) {
            return $this->compileBinaryOp($node);
        }

        if ($node instanceof Node\Scalar\IntegerValue) {
            $this->lines[] = '    push ' . $node->getValue();
        }
    }

    private function compileBinaryOp(Node\BinaryOp\AbstractBinaryOp $node)
    {
        $this->compileNode($node->getLeft());
        $this->compileNode($node->getRight());

        $this->lines[] = '    pop rax';
        $this->lines[] = '    pop rbx';

        switch (get_class($node)) {
            case Node\BinaryOp\Add::class:
                $this->lines[] = '    add rax,rbx';
                break;
            case Node\BinaryOp\Subtract::class:
                $this->lines[] = '    sub rax,rbx';
                break;
            case Node\BinaryOp\Multiply::class:
                $this->lines[] = '    imul rax,rbx';
                break;
            case Node\BinaryOp\Divide::class:
                $this->lines[] = '    idiv rax,rbx';
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Unknown binary operator: %s', get_class($node)));
        }

        $this->lines[] = '    push rax';
    }
}
