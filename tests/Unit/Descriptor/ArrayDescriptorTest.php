<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Descriptor;

use Psi\Component\Description\Descriptor\ArrayDescriptor;

class ArrayDescriptorTest extends \PHPUnit_Framework_TestCase
{
    private $descriptor;

    public function setUp()
    {
        $this->descriptor = new ArrayDescriptor(['foo' => 'bar']);
    }

    public function testGetValue()
    {
        $this->assertEquals(['foo' => 'bar'], $this->descriptor->getValues());
    }
}
