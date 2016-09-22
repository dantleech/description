<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class IntegerDescriptor implements DescriptorInterface
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * Return the integer value.
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
