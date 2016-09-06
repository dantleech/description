<?php

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class BooleanDescriptor implements DescriptorInterface
{
    private $key;
    private $value;

    public function __construct($key, bool $value)
    {
        $this->value = (bool) $value;
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): bool
    {
        return $this->value;
    }
}

