<?php

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class ArrayDescriptor implements DescriptorInterface
{
    private $key;
    private $values;

    public function __construct(string $key, array $values)
    {
        $this->values = $values;
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValues(): array
    {
        return $this->values;
    }
}

