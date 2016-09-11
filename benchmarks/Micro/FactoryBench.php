<?php

namespace Psi\Component\Description\Benchmarks\Micro;

use Psi\Component\Description\Tests\Functional\Example\FooEnhancer;
use Psi\Component\Description\DescriptionFactory;
use Psi\Component\Description\Schema\Extension\StandardExtension;
use Psi\Component\Description\Tests\Functional\Example\Foo;
use Psi\Component\Description\Subject;
use Psi\Component\Description\Schema\Schema;
use Psi\Component\Description\Schema\Extension\HierarchyExtension;

/**
 * @BeforeMethods({"setUp"})
 * @Revs(1000)
 * @Iterations(10)
 */
class FactoryBench
{
    private $factory;
    private $validatedFactory;

    public function setUp()
    {
        $this->factory = new DescriptionFactory([
            new FooEnhancer(),
        ]);

        $schema = new Schema([
            new StandardExtension(),
            new HierarchyExtension(),
        ]);

        $this->validatedFactory = new DescriptionFactory([
            new FooEnhancer(),
        ], $schema);
    }

    public function benchFactory()
    {
        $foo = new Foo();
        $foo->title = 'Hello World';

        $this->factory->describe(Subject::createFromObject($foo));
    }

    public function benchValidatedFactory()
    {
        $foo = new Foo();
        $foo->title = 'Hello World';

        $this->validatedFactory->describe(Subject::createFromObject($foo));
    }
}
