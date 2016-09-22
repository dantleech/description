<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Descriptor;

use Psi\Component\Description\Descriptor\DateTimeDescriptor;

class DateTimeDescriptorTest extends \PHPUnit_Framework_TestCase
{
    private $descriptor;

    public function setUp()
    {
        $this->descriptor = new DateTimeDescriptor(new \DateTime('2016-01-01 00:00:00'));
    }

    public function testGetValue()
    {
        $this->assertEquals(new \DateTime('2016-01-01 00:00:00'), $this->descriptor->getDateTime());
        $this->assertEquals('2016-01-01', $this->descriptor->format('Y-m-d'));
    }
}
