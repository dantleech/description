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
use Psi\Component\Description\DescriptionEnhancerInterface;
use Psi\Component\Description\DescriptionFactory;
use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\DescriptorInterface;

class DescriptionFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $enhancer1;
    private $enhancer2;

    public function setUp()
    {
        $this->enhancer1 = $this->prophesize(DescriptionEnhancerInterface::class);
        $this->enhancer2 = $this->prophesize(DescriptionEnhancerInterface::class);
        $this->object = new \stdClass;
    }

    /**
     * It should return an enhanceed description.
     */
    public function testGetResourceDescription()
    {
        $descriptor1 = $this->prophesize(DescriptorInterface::class);
        $descriptor1->getKey()->willReturn('barfoo');
        $descriptor2 = $this->prophesize(DescriptorInterface::class);
        $descriptor2->getKey()->willReturn('foobar');

        $this->enhancer1->enhance(Argument::type(Description::class))
            ->will(function ($args) use ($descriptor1) {
                $description = $args[0];
                $description->set($descriptor1->reveal());
            });
        $this->enhancer1->supports(Argument::type(Description::class))->willReturn(true);
        $this->enhancer2->enhance(Argument::type(Description::class))
            ->will(function ($args) use ($descriptor2) {
                $description = $args[0];
                $description->set($descriptor2->reveal());
            });
        $this->enhancer2->supports(Argument::type(Description::class))->willReturn(true);

        $description = $this->createFactory([
            $this->enhancer1->reveal(),
            $this->enhancer2->reveal(),
        ])->getPayloadDescriptionFor($this->object);

        $this->assertInstanceOf(Description::class, $description);
        $this->assertSame($descriptor1->reveal(), $description->get('barfoo'));
        $this->assertSame($descriptor2->reveal(), $description->get('foobar'));
    }

    /**
     * It should ignore providers that do not support the resource.
     */
    public function testIgnoreNonSupporters()
    {
        $this->enhancer1->enhance(Argument::cetera())->shouldNotBeCalled();
        $this->enhancer1->supports(Argument::type(Description::class))->willReturn(false);

        $this->enhancer2->enhance(Argument::cetera())->shouldBeCalled();
        $this->enhancer2->supports(Argument::type(Description::class))->willReturn(true);

        $this->createFactory([
            $this->enhancer1->reveal(),
            $this->enhancer2->reveal(),
        ])->getPayloadDescriptionFor($this->object);
    }

    /**
     * It should work when no enhancers are provided.
     */
    public function testNoEnhancers()
    {
        $description = $this->createFactory([])->getPayloadDescriptionFor($this->object);
        $this->assertInstanceOf(Description::class, $description);
    }

    private function createFactory(array $enhancers)
    {
        return new DescriptionFactory($enhancers);
    }
}
