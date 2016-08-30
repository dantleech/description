<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Component\Description\Tests\Unit\Repository;

use Symfony\Cmf\Component\Description\Description;
use Symfony\Cmf\Component\Description\Descriptor;
use Puli\Repository\Api\Object\PuliObject;

class DescriptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Description
     */
    private $description;

    /**
     * @var PuliObject
     */
    private $object;

    public function setUp()
    {
        $this->object = new \stdClass();
        $this->description = new Description($this->object);
    }

    /**
     * It should allow values to be set and retrieved.
     */
    public function testGetSet()
    {
        $this->description->set(Descriptor::TYPE_ALIAS, 'page');
        $this->description->set(Descriptor::LINK_EDIT_HTML, '/path/to/edit');
        $this->description->set('custom.key', 'Hello');

        $this->assertEquals('page', $this->description->get(Descriptor::TYPE_ALIAS));

        $this->assertTrue($this->description->has(Descriptor::TYPE_ALIAS));
        $this->assertFalse($this->description->has('hello'));
        $this->assertEquals([
            Descriptor::TYPE_ALIAS => 'page',
            Descriptor::LINK_EDIT_HTML => '/path/to/edit',
            'custom.key' => 'Hello',
            Descriptor::CLASS_FQN => 'stdClass',

        ], $this->description->all());
    }

    /**
     * It should throw an exception if a non-scalar value is set.
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Only scalar and array values are allowed as descriptor values, got "object" when setting descriptor "hello"
     */
    public function testSetNonScalar()
    {
        $this->description->set('hello', new \stdClass());
    }

    /**
     * It should throw an exception when requesting an unsupported descriptor.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Supported descriptors: "class_fqn", "foo", "bar"
     */
    public function testGetUnsupported()
    {
        $this->description->set('foo', 'bar');
        $this->description->set('bar', 'foo');
        $this->description->get('not there');
    }

    /**
     * It should return the object that it describes.
     */
    public function testGetObject()
    {
        $object = $this->description->getObject();
        $this->assertSame($this->object, $object);
    }
}
