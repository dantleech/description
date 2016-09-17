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

        $this->descriptor1->getKey()->willReturn('foo');
        $this->descriptor2->getKey()->willReturn('bar');
    }

    /**
     * It should allow descriptors to be set.
     */
    public function testDescriptorSetGet()
    {
        $description = $this->create();
        $description->set($this->descriptor1->reveal());

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
        $description->set($this->descriptor1->reveal());

        $this->assertTrue($description->has('foo'));
        $this->assertFalse($description->has('baz'));
    }

    /**
     * It should overwrite descriptors.
     */
    public function testOverwrite()
    {
        $description = $this->create();
        $description->set($this->descriptor1->reveal());
        $description->set(clone $this->descriptor1->reveal());

        $this->assertTrue($description->has('foo'));
    }

    /**
     * It should return all descriptors.
     */
    public function testReturnAll()
    {
        $description = $this->create();
        $description->set($this->descriptor1->reveal());
        $description->set($this->descriptor2->reveal());

        $this->assertCount(2, $description->all());
    }

    protected function create()
    {
        return new Description();
    }
}
