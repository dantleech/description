<?php

namespace Psi\Component\Description\Tests\Unit;

use Psi\Component\Description\Schema\Schema;
use Psi\Component\Description\ValidatedDescription;
use Psi\Component\Description\DescriptorInterface;
use Prophecy\Argument;

class ValidatedDescriptionTest extends DescriptionTest
{
    private $schema;
    private $object;

    public function setUp()
    {
        parent::setUp();
        $this->schema = $this->prophesize(Schema::class);
        $this->object = new \stdClass();
    }

    /**
     * {@inheritdoc}
     */
    public function testDescriptorSetGet()
    {
        $this->schema->validate(Argument::type(DescriptorInterface::class))->shouldBeCalled();
        $this->schema->validateKey('foo')->shouldBeCalled();
        parent::testDescriptorSetGet();
    }

    /**
     * {@inheritdoc}
     */
    public function testHasDescriptor()
    {
        $this->schema->validate(Argument::type(DescriptorInterface::class))->shouldBeCalled();
        $this->schema->validateKey('baz')->shouldBeCalled();
        $this->schema->validateKey('foo')->shouldBeCalled();
        parent::testHasDescriptor();
    }

    protected function create()
    {
        return new ValidatedDescription(parent::create(), $this->schema->reveal());
    }
}
