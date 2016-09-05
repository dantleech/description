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

/**
 * Descriptive metadata for objects.
 */
class Description
{
    /**
     * @var array
     */
    private $descriptors = [];

    /**
     * @var object
     */
    private $object;

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @param PuliObject $object
     */
    public function __construct($object, Schema $schema = null)
    {
        $this->object = $object;
        $this->schema = $schema;

        // this should be overridden early by any enhancers that issue proxies.
        $this->set('std:class_fqn', get_class($object));
    }

    /**
     * Return the descriptors value for the given descriptor.
     *
     * @param string $descriptor
     *
     * @return mixed
     */
    public function get($descriptorKey): DescriptorInterface
    {
        if (!isset($this->descriptors[$descriptorKey])) {
            if (null !== $this->schema) {
                $this->schema->validateKey($descriptorKey);
            }

            throw new \InvalidArgumentException(sprintf(
                'Descriptor "%s" not supported for object of class "%s". Supported descriptors: "%s"',
                $descriptor,
                get_class($this->object),
                implode('", "', array_keys($this->descriptors))
            ));
        }

        return $this->descriptors[$descriptor];
    }

    /**
     * Return true if the given descriptor has been set.
     *
     * @param string $descriptor
     *
     * @return bool
     */
    public function has($descriptor): bool
    {
        if (null !== $this->schema) {
            $this->schema->validateKey($descriptor);
        }

        return isset($this->descriptors[$descriptor]);
    }

    /**
     * Return all of the descriptors.
     *
     * @return array
     */
    public function all()
    {
        return $this->descriptors;
    }

    /**
     * Set value for descriptors descriptor.
     *
     * Note that:
     *
     * - It is possible to overwrite existing descriptors.
     *
     * - Where possible the descriptor should be the value of one of the constants
     *   defined in the Descriptor class.
     *
     * @param string $descriptor
     * @param mixed  $value
     */
    public function set(DescriptorInterface $descriptor)
    {
        if (null !== $this->schema) {
            $this->schema->validate($descriptor);
        }

        $this->descriptors[$descriptor->getKey()] = $descriptor;
    }

    /**
     * Return the object for which this is the description.
     *
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }
}
