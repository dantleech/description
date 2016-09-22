<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

/**
 * Descriptor for an array of values.
 */
class ArrayDescriptor implements DescriptorInterface
{
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Return an array of values.
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
