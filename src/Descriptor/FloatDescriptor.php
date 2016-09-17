<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class FloatDescriptor implements DescriptorInterface
{
    private $key;
    private $value;

    public function __construct(string $key, float $value)
    {
        $this->value = $value;
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Return the float value.
     */
    public function getValue(): float
    {
        return $this->value;
    }
}
