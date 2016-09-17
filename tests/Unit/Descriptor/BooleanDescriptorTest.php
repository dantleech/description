<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Descriptor;

use Psi\Component\Description\Descriptor\BooleanDescriptor;

class BooleanDescriptorTest extends \PHPUnit_Framework_TestCase
{
    private $descriptor;

    public function setUp()
    {
        $this->descriptor = new BooleanDescriptor('foo', true);
    }

    public function testGetValue()
    {
        $this->assertEquals('foo', $this->descriptor->getKey());
        $this->assertTrue($this->descriptor->getValue());
    }
}
