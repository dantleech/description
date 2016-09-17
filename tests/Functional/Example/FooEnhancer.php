<?php

namespace Psi\Component\Description\Tests\Functional\Example;

use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\Subject;
use Psi\Component\Description\Descriptor\BooleanDescriptor;
use Psi\Component\Description\Descriptor\StringDescriptor;
use Psi\Component\Description\Descriptor\UriDescriptor;
use Psi\Component\Description\Descriptor\ClassDescriptor;

class FooEnhancer implements EnhancerInterface
{
    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {
        $description->set(new ClassDescriptor('std.class', $class));
        $description->set(new BooleanDescriptor('hierarchy.allow_children', true));
        $description->set(new UriDescriptor('std.uri.update', 'https://www.example.com/foobar'));
    }

    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
        $description->set(new StringDescriptor('std.title', $subject->getObject()->title));
    }

    public function supports(Subject $subject)
    {
        return $subject->getClass()->getName() === Foo::class;
    }
}
