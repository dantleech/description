<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psi\Component\Description\Tests\Unit;

use Psi\Component\Description\Description;
use Psi\Component\Description\Descriptor;
use Puli\Repository\Api\Object\PuliObject;
use Psi\Component\Description\DescriptorInterface;

class DescriptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Description
     */
    protected $description;

    /**
     * @var PuliObject
     */
    private $object;

    public function setUp()
    {
        $this->object = new \stdClass();
        $this->descriptor1 = $this->prophesize(DescriptorInterface::class);
        $this->descriptor2 = $this->prophesize(DescriptorInterface::class);
        $this->descriptor1override = $this->prophesize(DescriptorInterface::class);
    }

    /**
     * It should allow descriptors to be set.
     */
    public function testDescriptorSetGet()
    {
        $description = $this->create();
        $description->set('foo', $this->descriptor1->reveal());

        $this->assertSame($this->descriptor1->reveal(), $description->get('foo'));
    }

    /**
     * It should throw an exception if a descriptor does not exist.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Descriptor "foo" is not supported
     */
    public function testDescriptorNotExist()
    {
        $description = $this->create();
        $description->get('foo');
    }

    /**
     * It should say if a descriptor exists or not.
     */
    public function testHasDescriptor()
    {
        $description = $this->create();
        $description->set('foo', $this->descriptor1->reveal());

        $this->assertTrue($description->has('foo'));
        $this->assertFalse($description->has('baz'));
    }

    /**
     * It should override descriptors.
     */
    public function testOverride()
    {
        $description = $this->create();
        $description->set('foo', $this->descriptor1->reveal());
        $description->set('foo', $this->descriptor1override->reveal());

        $this->assertTrue($description->has('foo'));
        $this->assertSame($this->descriptor1override->reveal(), $description->get('foo'));
    }

    /**
     * It should return all descriptors.
     */
    public function testReturnAll()
    {
        $description = $this->create();
        $description->set('foo', $this->descriptor1->reveal());
        $description->set('bar', $this->descriptor2->reveal());

        $this->assertCount(2, $description->all());
    }

    /**
     * Descriptiors with a lower priority should not override descriptors with a higher priority.
     */
    public function testPriorityLower()
    {
        $description = $this->create();
        $description->set('foo', $this->descriptor1->reveal(), 255);
        $description->set('foo', $this->descriptor1override->reveal(), 50);

        $this->assertSame($this->descriptor1->reveal(), $description->get('foo'));
    }

    /**
     * Descriptors with a higher priority should override descriptors with a lower priority.
     */
    public function testPriorityHigher()
    {
        $description = $this->create();
        $description->set('foo', $this->descriptor1->reveal(), 255);
        $description->set('foo', $this->descriptor1override->reveal(), 550);

        $this->assertSame($this->descriptor1override->reveal(), $description->get('foo'));
    }

    protected function create()
    {
        return new Description();
    }
}
