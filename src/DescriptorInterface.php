<?php

namespace Symfony\Cmf\Component\Description;

/**
 * Descriptor classes are value objects containing a specific description value
 * They may contain single or multiple values.
 *
 * ```
 * class FooDescriptor implements DescriptorInterface
 * {
 *     private $foo;
 *
 *     public function __construct($foo)
 *     {
 *         $this->foo = $foo;
 *     }
 *
 *     public function getFoo()
 *     {
 *         return $this->foo;
 *     }
 * }
 * ```
 */
interface DescriptorInterface
{
    /**
     * Return the key which corresponds to this descriptor, e.g. "title"
     */
    public function getKey();
}
