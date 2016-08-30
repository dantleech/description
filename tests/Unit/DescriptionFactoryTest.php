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
use Symfony\Cmf\Component\Description\DescriptionEnhancerInterface;
use Prophecy\Argument;
use Symfony\Cmf\Component\Description\DescriptionFactory;
use Puli\Repository\Api\Resource\PuliResource;

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
        $this->enhancer1->enhance(Argument::type(Description::class))
            ->will(function ($args) {
                $description = $args[0];
                $description->set('foobar', 'barfoo');
            });
        $this->enhancer1->supports(Argument::type(Description::class))->willReturn(true);
        $this->enhancer2->enhance(Argument::type(Description::class))
            ->will(function ($args) {
                $description = $args[0];
                $description->set('barfoo', 'foobar');
            });
        $this->enhancer2->supports(Argument::type(Description::class))->willReturn(true);

        $description = $this->createFactory([
            $this->enhancer1->reveal(),
            $this->enhancer2->reveal(),
        ])->getPayloadDescriptionFor($this->object);

        $this->assertInstanceOf(Description::class, $description);
        $this->assertEquals('barfoo', $description->get('foobar'));
        $this->assertEquals('foobar', $description->get('barfoo'));
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
