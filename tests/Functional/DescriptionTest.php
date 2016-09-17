<?php

namespace Psi\Component\Description\Tests\Functional;

use Psi\Component\Description\Tests\Functional\Example\FooEnhancer;
use Psi\Component\Description\Subject;
use Psi\Component\Description\DescriptionFactory;
use Psi\Component\Description\Tests\Functional\Example\Foo;
use Psi\Component\Description\Schema\Schema;
use Psi\Component\Description\Schema\Extension\StandardExtension;
use Psi\Component\Description\Schema\Extension\HierarchyExtension;

class DescriptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DescriptionFactory
     */
    private $factory;

    public function setUp()
    {
        $schema = new Schema([
            new StandardExtension(),
            new HierarchyExtension(),
        ]);

        $this->factory = new DescriptionFactory([
            new FooEnhancer(),
        ], $schema);
    }

    /**
     * It should describe an object.
     */
    public function testDescriptionForObject()
    {
        $foo = new Foo();
        $foo->title = 'Hello World';

        $description = $this->factory->describe(Subject::createFromObject($foo));
        $this->assertEquals('Hello World', $description->get('std.title')->getValue());
    }

    /**
     * It should describe an object.
     */
    public function testDescriptionForClass()
    {
        $foo = new Foo();
        $foo->title = 'Hello World';

        $description = $this->factory->describe(Subject::createFromClass(Foo::class));
        $this->assertFalse($description->has('std.title'));
        $this->assertEquals(Foo::class, $description->get('std.class')->getClass()->getName());
    }
}
