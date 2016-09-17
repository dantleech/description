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
        $description->set(new BooleanDescriptor('hierarchy.allow_children', true));
        $description->set(new ArrayDescriptor('hierarchy.children_types', ['foo', 'bar']));
        $description->set(new UriCollectionDescriptor('hierarchy.uris.create_child', ['foo' => 'https://example.com/edit/123']));
    }
}
