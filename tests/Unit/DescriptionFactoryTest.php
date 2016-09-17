<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psi\Component\Description\Tests\Unit\Repository;

use Prophecy\Argument;
use Psi\Component\Description\Description;
use Psi\Component\Description\EnhancerInterface;
use Psi\Component\Description\DescriptionFactory;
use Psi\Component\Description\ValidatedDescription;
use Psi\Component\Description\Schema\Schema;
use Psi\Component\Description\Subject;

class DescriptionFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $enhancer1;
    private $enhancer2;
    private $schema;

    public function setUp()
    {
        $this->enhancer1 = $this->prophesize(EnhancerInterface::class);
        $this->enhancer2 = $this->prophesize(EnhancerInterface::class);
        $this->schema = $this->prophesize(Schema::class);
        $this->object = new \stdClass();
    }

    /**
     * It should return an enhanceed description.
     */
    public function testGetResourceDescription()
    {
        $subject = Subject::createFromObject($this->object);

        $this->enhancer1->enhanceFromClass(Argument::type(Description::class), Argument::type(\ReflectionClass::class))->shouldBeCalled();
        $this->enhancer1->enhanceFromObject(Argument::type(Description::class), Argument::type(Subject::class))->shouldBeCalled();
        $this->enhancer1->supports($subject)->willReturn(true);
        $this->enhancer2->enhanceFromClass(Argument::type(Description::class), Argument::type(\ReflectionClass::class))->shouldBeCalled();
        $this->enhancer2->enhanceFromObject(Argument::type(Description::class), Argument::type(Subject::class))->shouldBeCalled();
        $this->enhancer2->supports($subject)->willReturn(true);

        $description = $this->createFactory([
            $this->enhancer1->reveal(),
            $this->enhancer2->reveal(),
        ])->describe($subject);

        $this->assertInstanceOf(Description::class, $description);
    }

    /**
     * It should ignore providers that do not support the resource.
     */
    public function testIgnoreNonSupporters()
    {
        $subject = Subject::createFromObject($this->object);
        $this->enhancer1->enhanceFromClass(Argument::type(Description::class), Argument::type(\ReflectionClass::class))->shouldNotBeCalled();
        $this->enhancer1->enhanceFromObject(Argument::type(Description::class), Argument::type(Subject::class))->shouldNotBeCalled();
        $this->enhancer1->supports($subject)->willReturn(false);

        $this->enhancer2->enhanceFromClass(Argument::type(Description::class), Argument::type(\ReflectionClass::class))->shouldBeCalled();
        $this->enhancer2->enhanceFromObject(Argument::type(Description::class), Argument::type(Subject::class))->shouldBeCalled();
        $this->enhancer2->supports($subject)->willReturn(true);

        $this->createFactory([
            $this->enhancer1->reveal(),
            $this->enhancer2->reveal(),
        ])->describe($subject);
    }

    /**
     * It should return a non-validating description when no schema is passed.
     */
    public function testNoSchema()
    {
        $subject = Subject::createFromObject($this->object);

        $description = $this->createFactory([])->describe($subject);
        $this->assertEquals(Description::class, get_class($description));
    }

    /**
     * It should return a validated description when the schema is passed.
     */
    public function testValidatedDescription()
    {
        $subject = Subject::createFromObject($this->object);

        $description = $this->createFactory([], $this->schema->reveal())->describe($subject);
        $this->assertEquals(ValidatedDescription::class, get_class($description));
    }

    /**
     * It should not invoke an object description if no object is available.
     */
    public function testEnhanceNoObject()
    {
        $subject = Subject::createFromClass(\stdClass::class);

        $this->enhancer1->enhanceFromClass(Argument::type(Description::class), Argument::type(\ReflectionClass::class))->shouldBeCalled();
        $this->enhancer1->enhanceFromObject(Argument::type(Description::class), Argument::type(Subject::class))->shouldNotBeCalled();
        $this->enhancer1->supports($subject)->willReturn(true);

        $this->createFactory([
            $this->enhancer1->reveal(),
        ])->describe($subject);
    }

    private function createFactory(array $enhancers, Schema $schema = null)
    {
        return new DescriptionFactory($enhancers, $schema);
    }
}
