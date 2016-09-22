<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Descriptor;

use Psi\Component\Description\Descriptor\ClassDescriptor;

class ClassDescriptorTest extends \PHPUnit_Framework_TestCase
{
    private $descriptor;

    public function setUp()
    {
        $this->descriptor = new ClassDescriptor(new \ReflectionClass(\stdClass::class));
    }

    public function testGetValue()
    {
        $this->assertEquals(new \ReflectionClass(\stdClass::class), $this->descriptor->getClass());
    }
}
