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
     * @param PuliObject $object
     */
    public function __construct($object)
    {
        $this->object = $object;

        // this should be overridden early by any enhancers that issue proxies.
        $this->set(Descriptor::CLASS_FQN, get_class($object));
    }

    /**
     * Return the descriptors value for the given descriptor.
     *
     * @param string $descriptor
     *
     * @return mixed
     */
    public function get($descriptor)
    {
        if (!isset($this->descriptors[$descriptor])) {
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
    public function has($descriptor)
    {
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
    public function set($descriptor, $value)
    {
        if (null !== $value && !is_scalar($value) && !is_array($value)) {
            throw new \InvalidArgumentException(sprintf(
                'Only scalar and array values are allowed as descriptor values, got "%s" when setting descriptor "%s"',
                gettype($value), $descriptor
            ));
        }

        $this->descriptors[$descriptor] = $value;
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
