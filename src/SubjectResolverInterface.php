<?php

declare(strict_types=1);

namespace Psi\Component\Description;

/**
 * Subject resolvers are allowed to *replace* a given subject by returning a
 * new subject.
 *
 * This can be used when an object is just a proxy for another object and you
 * wish to describe the other object rather than the given object.
 */
interface SubjectResolverInterface
{
    /**
     * Resolve the given subject.
     *
     * Note that the given subject may or may not have an object. All resolvers
     * MUST test if a subject has an object and act accordingly.
     *
     * ```
     * // resolve value if
     * if ($subject->hasObject() && $subject->getClass()->isSubclassOf(FooInterface::class)) {
     *      return Subject::createFromObject($subject->getObject()->getAnotherObject());
     * }
     *
     * return $subject;
     * ```
     */
    public function resolve(Subject $resolve): Subject;
}
