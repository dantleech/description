<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class StringDescriptor implements DescriptorInterface
{
    private $key;
    private $value;

    public function __construct(string $key, string $value)
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
     * Return the string value.
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
