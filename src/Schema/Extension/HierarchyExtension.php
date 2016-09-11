<?php

declare(strict_types=1);

namespace Psi\Component\Description\Schema\Extension;

use Psi\Component\Description\Schema\ExtensionInterface;
use Psi\Component\Description\Schema\Builder;
use Psi\Component\Description\Descriptor\BooleanDescriptor;
use Psi\Component\Description\Descriptor\ArrayDescriptor;
use Psi\Component\Description\Descriptor\UriCollectionDescriptor;

/**
 * Standard extension for providing hierarchical descriptors.
 *
 * Can be applied to file systems, hierarchical databases, etc.
 */
class HierarchyExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildSchema(Builder $builder)
    {
        $builder->add('allow_children', BooleanDescriptor::class, 'This class is allowed to have children');
        $builder->add('children_types', ArrayDescriptor::class, 'Valid children types');
        $builder->add('uris.create_child', UriCollectionDescriptor::class, 'Collection of URLs where children can be created (keys are the child types)');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hierarchy';
    }
}
