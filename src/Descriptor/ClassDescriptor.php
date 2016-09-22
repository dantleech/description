<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class ClassDescriptor implements DescriptorInterface
{
    private $class;

    public function __construct(\ReflectionClass $class)
    {
        $this->class = $class;
    }

    /**
     * Return the reflection class.
     */
    public function getClass(): \ReflectionClass
    {
        return $this->class;
    }
}
