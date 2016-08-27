<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Component\Description\Tests\Unit\Description\Enhancer\Doctrine;

use Symfony\Cmf\Component\Description\Description;
use Symfony\Cmf\Component\Document\Repository\Document\CmfDocument;
use Symfony\Cmf\Component\Description\Descriptor;
use Doctrine\ODM\PHPCR\Mapping\ClassMetadataFactory;
use Symfony\Cmf\Component\Description\Enhancer\Doctrine\PhpcrOdmEnhancer;
use Puli\Repository\Api\Document\PuliDocument;
use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;

class PhpcrOdmEnhancerTest extends \PHPUnit_Framework_TestCAse
{
    private $metadataFactory;
    private $enhancer;
    private $document;
    private $odmMetadata;
    private $description;

    public function setUp()
    {
        $this->metadataFactory = $this->prophesize(ClassMetadataFactory::class);
        $this->enhancer = new PhpcrOdmEnhancer($this->metadataFactory->reveal());

        $this->odmMetadata = $this->prophesize(ClassMetadata::class);
        $this->document = new \stdClass();
        $this->description = new Description($this->document);
    }

    /**
     * It should return true it supports a given document.
     */
    public function testSupportsDocument()
    {
        $this->metadataFactory->hasMetadataFor(\stdClass::class)->willReturn(true);

        $result = $this->enhancer->supports($this->description);
        $this->assertTrue($result);
    }

    /**
     * It should return false if the document is not known by the PHPCR-ODM metadata factory.
     */
    public function testNotSupportedByPhpcrOdm()
    {
        $this->metadataFactory->hasMetadataFor(\stdClass::class)->willReturn(false);

        $this->assertFalse(
            $this->enhancer->supports($this->description)
        );
    }

    /**
     * It should enhance the description with the child mapping information from the PHPCR-ODM metadata.
     */
    public function testEnhanceDescription()
    {
        // object the implements an allowed interface
        $mappedObject1 = $this->prophesize();
        $mappedObject1->willImplement(FooInterface::class);
        $metadata1 = $this->prophesize(ClassMetadata::class);
        $metadata1->name = get_class($mappedObject1->reveal());
        $metadata1->getReflectionClass()->willReturn(new \ReflectionClass($metadata1->name));

        // object the extends an allowed abstract class
        $mappedObject2 = $this->prophesize();
        $mappedObject2->willExtend(AbstractFoo::class);
        $metadata2 = $this->prophesize(ClassMetadata::class);
        $metadata2->name = get_class($mappedObject2->reveal());
        $metadata2->getReflectionClass()->willReturn(new \ReflectionClass($metadata2->name));

        // object of exact type that is allowed
        $mappedObject3 = $this->prophesize();
        $metadata3 = $this->prophesize(ClassMetadata::class);
        $metadata3->name = get_class($mappedObject3->reveal());
        $metadata3->getReflectionClass()->willReturn(new \ReflectionClass($metadata3->reveal()));

        // object that is not permitted
        $metadata4 = $this->prophesize(ClassMetadata::class);
        $metadata4->name = NotAllowedFoo::class;
        $metadata4->getReflectionClass()->willReturn(new \ReflectionClass($metadata4->reveal()));

        $this->metadataFactory->getMetadataFor('stdClass')->willReturn($this->odmMetadata->reveal());
        $this->metadataFactory->getAllMetadata()->willReturn([
            $metadata1->reveal(),
            $metadata2->reveal(),
            $metadata3->reveal(),
        ]);

        $this->odmMetadata->isLeaf()->willReturn(false);
        $this->odmMetadata->getChildClasses()->willReturn([
            FooInterface::class,
            AbstractFoo::class,
            $metadata3->name,
        ]);

        $this->enhancer->enhance($this->description);
        $this->assertTrue($this->description->get(Descriptor::CHILDREN_ALLOW));
        $this->assertEquals([
            $metadata1->name,
            $metadata2->name,
            $metadata3->name,
        ], $this->description->get(Descriptor::CHILDREN_TYPES));
    }
}

interface FooInterface
{
}

abstract class AbstractFoo
{
}

class NotAllowedFoo
{
}
