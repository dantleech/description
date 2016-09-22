<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class StringDescriptor implements DescriptorInterface
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Return the string value.
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
