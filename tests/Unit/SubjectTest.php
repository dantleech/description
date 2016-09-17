<?php

namespace Psi\Component\Description\Tests\Unit;

use Psi\Component\Description\Subject;

class SubjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * It should create a subject from a class.
     */
    public function testCreateFromClass()
    {
        $subject = Subject::createFromClass(\stdClass::class);
        $this->assertInstanceOf(Subject::class, $subject);
        $this->assertInstanceOf(\ReflectionClass::class, $subject->getClass());
        $this->assertEquals(\stdClass::class, $subject->getClass()->getName());
        $this->assertFalse($subject->hasObject());
    }

    /**
     * It should create a subject from an object.
     */
    public function testCreateFromObject()
    {
        $object = new \stdClass();
        $subject = Subject::createFromObject($object);
        $this->assertInstanceOf(Subject::class, $subject);
        $this->assertInstanceOf(\ReflectionClass::class, $subject->getClass());
        $this->assertEquals(\stdClass::class, $subject->getClass()->getName());
        $this->assertSame($object, $subject->getObject());
        $this->assertTrue($subject->hasObject());
    }
}
