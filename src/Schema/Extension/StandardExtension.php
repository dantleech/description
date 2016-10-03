<?php

declare(strict_types=1);

namespace Psi\Component\Description\Schema\Extension;

use Psi\Component\Description\Schema\ExtensionInterface;
use Psi\Component\Description\Schema\Builder;
use Psi\Component\Description\Descriptor\UriDescriptor;
use Psi\Component\Description\Descriptor\StringDescriptor;
use Psi\Component\Description\Descriptor\DateTimeDescriptor;
use Psi\Component\Description\Descriptor\ClassDescriptor;

/**
 * Standard descriptors.
 *
 * Provide a list of general, commonly required, descriptors.
 */
class StandardExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildSchema(Builder $builder)
    {
        $builder->add(
            'class',
            ClassDescriptor::class,
            'Resolved reflection class. Note that this should be the reflection of the *real* class '.
            '(as opposed to that of a proxy if applicable)'
        );
        $builder->add(
            'identifier',
            StringDescriptor::class,
            'Identifier for object (e.g. primary key / UUID)'
        );
        $builder->add('class.alias', StringDescriptor::class, 'Alias for the class');

        $builder->add('title', StringDescriptor::class, 'Title to use for the object instance');
        $builder->add('description', StringDescriptor::class, 'Description of the object');
        $builder->add('image', UriDescriptor::class, 'URL to image');
        $builder->add('created_at', DateTimeDescriptor::class, 'Date this object was created');
        $builder->add('updated_at', DateTimeDescriptor::class, 'Date this object was updated');

        $builder->add('uri.create', UriDescriptor::class, 'Uri to where the object can be created');
        $builder->add('uri.show', UriDescriptor::class, 'Uri to where the object can be shown');
        $builder->add('uri.update', UriDescriptor::class, 'Uri to where the object can be updated');
        $builder->add('uri.delete', UriDescriptor::class, 'Uri to where the object can be deleted');
        $builder->add('uri.list', UriDescriptor::class, 'Uri to where objects of the described objects class are listed');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'std';
    }
}
