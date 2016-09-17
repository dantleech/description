<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class IntegerDescriptor implements DescriptorInterface
{
    private $key;
    private $value;

    public function __construct(string $key, int $value)
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
     * Return the integer value.
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
