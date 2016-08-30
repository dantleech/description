<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Component\Description\Tests\Unit\Description\Enhancer;

use Sylius\Component\Resource\Metadata\RegistryInterface;
use Symfony\Cmf\Component\Description\Enhancer\Sylius\ResourceEnhancer;
use Symfony\Component\HttpFoundation\Request;
use Sylius\Component\Resource\Metadata\Metadata;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfigurationFactory;
use Symfony\Cmf\Component\Description\Description;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Component\Resource\Model\ResourceInterface;
use Prophecy\Argument;
use Symfony\Cmf\Component\Description\Descriptor;

class ObjectEnhancerTest extends \PHPUnit_Framework_TestCAse
{
    public function setUp()
    {
        $this->registry = $this->prophesize(RegistryInterface::class);
        $this->urlGenerator = $this->prophesize(UrlGeneratorInterface::class);
        $this->requestConfigurationFactory = $this->prophesize(RequestConfigurationFactory::class);
        $this->requestStack = $this->prophesize(RequestStack::class);

        $this->enhancer = new ResourceEnhancer(
            $this->registry->reveal(),
            $this->requestStack->reveal(),
            $this->requestConfigurationFactory->reveal(),
            $this->urlGenerator->reveal()
        );

        $this->request = $this->prophesize(Request::class);
        $this->object = new \stdClass();
        $this->metadata = $this->prophesize(Metadata::class);
        $this->requestConfiguration = $this->prophesize(RequestConfiguration::class);
        $this->payload = $this->prophesize(ResourceInterface::class);
        $this->stdDescription = new Description($this->object);
        $this->description = new Description($this->payload->reveal());
    }

    /**
     * It should return true if the payload is supported by Sylius.
     */
    public function testSupportedBySylius()
    {
        $this->registry->getByClass('stdClass')->willReturn($this->metadata->reveal());
        $this->assertTrue(
            $this->enhancer->supports($this->stdDescription)
        );
    }

    /**
     * It should return false if the payload is not supported by Sylius.
     */
    public function testNotSupportedBySylius()
    {
        $this->registry->getByClass('stdClass')->willThrow(new \InvalidArgumentException('foo'));
        $this->assertFalse(
            $this->enhancer->supports($this->stdDescription)
        );
    }

    /**
     * It should add sylius routes for a supported payload.
     */
    public function testEnhance()
    {
        $this->initEnhance();

        $description = new Description($this->payload->reveal());
        $this->enhancer->enhance($description);

        $this->assertEquals([
            Descriptor::LINK_SHOW_HTML => 'show/5',
            Descriptor::LINK_LIST_HTML => 'index/5',
            Descriptor::LINK_EDIT_HTML => 'update/5',
            Descriptor::LINK_CREATE_HTML => 'create/5',
            Descriptor::LINK_REMOVE_HTML => 'delete/5',
            Descriptor::CLASS_FQN => get_class($this->payload->reveal()),
        ], $description->all());
    }

    /**
     * It should add child type metadata if the CHILDREN_TYPE descriptor has previously been set.
     */
    public function testChildrenType()
    {
        $this->initEnhance();

        $this->urlGenerator->generate('create')->will(function ($args) {
            return '/create';
        });
        $this->metadata->getAlias()->willReturn('std.class');

        $description = new Description($this->payload->reveal());
        $description->set(Descriptor::CHILDREN_TYPES, [
            \stdClass::class,
        ]);

        $this->registry->getByClass(\stdClass::class)->willReturn($this->metadata->reveal());
        $this->enhancer->enhance($description);

        $this->assertEquals([
            Descriptor::LINK_SHOW_HTML => 'show/5',
            Descriptor::LINK_LIST_HTML => 'index/5',
            Descriptor::LINK_EDIT_HTML => 'update/5',
            Descriptor::LINK_CREATE_HTML => 'create/5',
            Descriptor::LINK_REMOVE_HTML => 'delete/5',
            Descriptor::CHILDREN_TYPES => [\stdClass::class],
            Descriptor::LINKS_CREATE_CHILD_HTML => ['std.class' => '/create?parent=5'],
            Descriptor::CLASS_FQN => get_class($this->payload->reveal()),
        ], $description->all());
    }

    private function initEnhance()
    {
        $this->payload->getId()->willReturn(5);

        $this->registry->getByClass(get_class($this->payload->reveal()))->willReturn($this->metadata->reveal());
        $this->requestStack->getCurrentRequest()->willReturn($this->request->reveal());
        $this->requestConfigurationFactory
            ->create($this->metadata->reveal(), $this->request->reveal())
            ->willReturn($this->requestConfiguration->reveal());
        $this->requestConfiguration->getRouteName(Argument::type('string'))->will(function ($args) {
            return $args[0];
        });
        $this->urlGenerator->generate(Argument::type('string'), Argument::type('array'))->will(function ($args) {
            return $args[0].'/'.$args[1]['id'];
        });
    }
}
