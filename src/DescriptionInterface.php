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

/**
 * Descriptive metadata for objects.
 */
interface DescriptionInterface
{
    /**
     * Return the descriptors value for the given descriptor.
     *
     * @param string $descriptor
     *
     * @return mixed
     */
    public function get($descriptorKey): DescriptorInterface;

    /**
     * Return true if the given descriptor has been set.
     *
     * @param string $descriptor
     *
     * @return bool
     */
    public function has($descriptor): bool;

    /**
     * Return all of the descriptors.
     *
     * @return array
     */
    public function all(): array;

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
    public function set(DescriptorInterface $descriptor);

    /**
     * Return the object for which this is the description.
     *
     * @return object
     */
    public function getObject();
}

