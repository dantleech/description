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

use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Cmf\Component\Description\Description;
use Symfony\Cmf\Component\Object\Repository\Object\CmfObject;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sonata\AdminBundle\Model\AuditManagerInterface;
use Sonata\AdminBundle\Route\PathInfoBuilder;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Prophecy\Argument;
use Symfony\Cmf\Component\Description\Descriptor;
use Symfony\Cmf\Component\Description\Enhancer\Sonata\AdminEnhancer;

class SonataAdminEnhancerTest extends \PHPUnit_Framework_TestCAse
{
    private $admin;
    private $pool;
    private $object;

    public function setUp()
    {
        $this->admin = new TestAdmin(
            'test',
            'stdClass',
            'FooController'
        );
        $this->container = new ContainerBuilder();
        $this->pool = new Pool($this->container, 'Test', 'logo');
        $this->pool->setAdminClasses([
            'stdClass' => ['std_class_admin'],
        ]);
        $this->pool->setAdminServiceIds(['std_class_admin']);

        $this->container->set('std_class_admin', $this->admin);
        $this->generator = $this->prophesize(UrlGeneratorInterface::class);
        $this->object = new \stdClass();

        $this->modelManager = $this->prophesize(ModelManagerInterface::class);
        $this->modelManager->getUrlsafeIdentifier(Argument::cetera())->will(function ($args) {
            return $args[0];
        });
        $this->routeBuilder = new PathInfoBuilder($this->prophesize(AuditManagerInterface::class)->reveal());
        $this->admin->setRouteBuilder($this->routeBuilder);
        $this->admin->setModelManager($this->modelManager->reveal());
        $this->admin->setBaseCodeRoute('test');
    }

    /**
     * It should provide a description.
     */
    public function testDescriptionProvide()
    {
        $this->generator->generate(Argument::cetera())->will(function ($args) {
            return '/'.$args[0];
        });

        $description = new Description($this->object);
        $enhancer = new AdminEnhancer($this->pool, $this->generator->reveal());
        $enhancer->enhance($description);

        $this->assertEquals('/std_class_edit', $description->get(Descriptor::LINK_EDIT_HTML));
        $this->assertEquals('/std_class_create', $description->get(Descriptor::LINK_CREATE_HTML));
        $this->assertEquals('/std_class_show', $description->get(Descriptor::LINK_SHOW_HTML));
        $this->assertEquals('/std_class_delete', $description->get(Descriptor::LINK_REMOVE_HTML));
    }
}

class TestAdmin extends Admin
{
    protected $baseRouteName = 'std_class';
    protected $baseRoutePattern = '_';

    public function __toString()
    {
        return 'Standard Class';
    }
}
