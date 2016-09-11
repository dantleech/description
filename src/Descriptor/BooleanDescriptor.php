<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class BooleanDescriptor implements DescriptorInterface
{
    private $key;
    private $value;

    public function __construct(string $key, bool $value)
    {
        $this->value = (bool) $value;
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
     * Return the boolean value.
     */
    public function getValue(): bool
    {
        return $this->value;
    }
}
