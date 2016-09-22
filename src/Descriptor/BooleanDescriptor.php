<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class BooleanDescriptor implements DescriptorInterface
{
    private $value;

    public function __construct(bool $value)
    {
        $this->value = (bool) $value;
    }

    /**
     * Return the boolean value.
     */
    public function getValue(): bool
    {
        return $this->value;
    }
}
