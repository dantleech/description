<?php

declare(strict_types=1);

namespace Psi\Component\Description;

/**
 * Descriptive metadata for objects.
 */
class Description implements DescriptionInterface
{
    /**
     * @var array
     */
    private $descriptors = [];

    /**
     * {@inheritdoc}
     */
    public function get($descriptorKey): DescriptorInterface
    {
        if (!isset($this->descriptors[$descriptorKey])) {
            throw new \InvalidArgumentException(sprintf(
                'Descriptor "%s" is not supported',
                $descriptorKey,
                implode('", "', array_keys($this->descriptors))
            ));
        }

        return $this->descriptors[$descriptorKey];
    }

    /**
     * {@inheritdoc}
     */
    public function has($descriptor): bool
    {
        return isset($this->descriptors[$descriptor]);
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->descriptors;
    }

    /**
     * {@inheritdoc}
     */
    public function set(DescriptorInterface $descriptor)
    {
        $this->descriptors[$descriptor->getKey()] = $descriptor;
    }
}
