<?php

declare(strict_types=1);

namespace Psi\Component\Description;

/**
 * Enhancers are responsible for retrieving metadata from their environment for
 * a given object instance, or class name, and adding standardized descriptors
 * to the given description.
 *
 * Each enhancer will be asked if it supports the given `Subject` before either
 * `enhanceFromClass` or `enhanceFromObject` are called.
 *
 * `enhanceFromObject` will only be called IF the subject has an object.
 */
interface EnhancerInterface
{
    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class);

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject);

    public function supports(Subject $subject);
}
