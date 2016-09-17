<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Descriptor;

use Psi\Component\Description\Descriptor\IntegerDescriptor;

class IntegerDescriptorTest extends \PHPUnit_Framework_TestCase
{
    private $descriptor;

    public function setUp()
    {
        $this->descriptor = new IntegerDescriptor('foo', 123);
    }

    public function testGetValue()
    {
        $this->assertEquals('foo', $this->descriptor->getKey());
        $this->assertEquals(123, $this->descriptor->getValue());
    }
}
