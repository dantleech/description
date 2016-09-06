<?php

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class ScalarDescriptor implements DescriptorInterface
{
    private $key;
    private $value;

    public function __construct(string $key, $value)
    {
        $this->value = $value;
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}
