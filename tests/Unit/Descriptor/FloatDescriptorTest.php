<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Descriptor;

use Psi\Component\Description\Descriptor\FloatDescriptor;

class FloatDescriptorTest extends \PHPUnit_Framework_TestCase
{
    private $descriptor;

    public function setUp()
    {
        $this->descriptor = new FloatDescriptor('foo', 123.12);
    }

    public function testGetValue()
    {
        $this->assertEquals('foo', $this->descriptor->getKey());
        $this->assertEquals(123.12, $this->descriptor->getValue());
    }
}
