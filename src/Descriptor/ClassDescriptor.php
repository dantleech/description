<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class ClassDescriptor implements DescriptorInterface
{
    private $key;
    private $class;

    public function __construct(string $key, \ReflectionClass $class)
    {
        $this->class = $class;
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
     * Return the reflection class.
     */
    public function getClass(): \ReflectionClass
    {
        return $this->class;
    }
}
