<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Component\Description;

use Symfony\Cmf\Component\Description\Schema\Schema;
use Symfony\Cmf\Component\Description\DescriptorInterface;
use Symfony\Cmf\Component\Description\Descriptor\ScalarDescriptor;
use Symfony\Cmf\Component\Description\DescriptionInterface;

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
     * @var object
     */
    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function get($descriptorKey): DescriptorInterface
    {
        if (!isset($this->descriptors[$descriptorKey])) {
            throw new \InvalidArgumentException(sprintf(
                'Descriptor "%s" is not supported for object of class "%s". Supported descriptors: "%s"',
                $descriptorKey,
                get_class($this->object),
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

    /**
     * {@inheritdoc}
     */
    public function getObject()
    {
        return $this->object;
    }
}
