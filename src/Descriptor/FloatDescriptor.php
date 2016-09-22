<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class FloatDescriptor implements DescriptorInterface
{
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * Return the float value.
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
