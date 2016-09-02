<?php

namespace Symfony\Cmf\Component\Description\Descriptor;

/**
 * This descriptor represents the true fully-qualified class name of the
 * described object.
 *
 * Note that the class name given by "get_class" for an object may in some
 * cases be an artificial constrution (e.g. a proxy class), in such cases
 * enhancers should set the "real" class name of the class with this descriptor
 * with the lowest priority available so that subsequent enhancers can use the
 * "true" class name.
 */
class ClassFqn extends AbstractScalarDescriptor
{
}
