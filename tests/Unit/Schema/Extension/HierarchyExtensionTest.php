<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Schema\Extension;

use Psi\Component\Description\Schema\Extension\HierarchyExtension;
use Psi\Component\Description\Descriptor\BooleanDescriptor;
use Psi\Component\Description\Descriptor\ArrayDescriptor;
use Psi\Component\Description\Descriptor\UriCollectionDescriptor;

class HierarchyExtensionTest extends ExtensionTestCase
{
    public function testExtension()
    {
        $description = $this->build(new HierarchyExtension());
        $description->set('hierarchy.allow_children', new BooleanDescriptor(true));
        $description->set('hierarchy.children_types', new ArrayDescriptor(['foo', 'bar']));
        $description->set('hierarchy.uris.create_child', new UriCollectionDescriptor(['foo' => 'https://example.com/edit/123']));
    }
}
