<?php

namespace Psi\Component\Description;

/**
 * Subject encapsulate the subject which is to be described.
 *
 * This can either be an object or a class name.
 *
 * The Subject should be instantiated with the static constructors
 * `createFromObject` and `createFromClass` as required.
 */
final class Subject
{
    private $object;
    private $class;

    final public function __construct()
    {
    }

    public static function createFromObject($object): Subject
    {
        $subject = new self();
        $subject->object = $object;
        $subject->class = new \ReflectionClass($object);

        return $subject;
    }

    public static function createFromClass(string $class): Subject
    {
        $subject = new self();
        $subject->class = new \ReflectionClass($class);

        return $subject;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function hasObject()
    {
        return null !== $this->object;
    }
}
