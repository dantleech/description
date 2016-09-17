<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

/**
 * Descriptor for an array of values.
 */
class ArrayDescriptor implements DescriptorInterface
{
    private $key;
    private $values;

    public function __construct(string $key, array $values)
    {
        $this->values = $values;
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
     * Return an array of values.
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
