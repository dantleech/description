<?php

declare(strict_types=1);

namespace Psi\Component\Description;

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
     * @param int    $priority
     */
    public function set(DescriptorInterface $descriptor, int $priority = 0);
}
