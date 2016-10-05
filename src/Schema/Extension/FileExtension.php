<?php

declare(strict_types=1);

namespace Psi\Component\Description\Schema\Extension;

use Psi\Component\Description\Schema\ExtensionInterface;
use Psi\Component\Description\Schema\Builder;
use Psi\Component\Description\Descriptor\IntegerDescriptor;
use Psi\Component\Description\Descriptor\StringDescriptor;

/**
 * Standard descriptors for files.
 */
class FileExtension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildSchema(Builder $builder)
    {
        $builder->add('mime-type', StringDescriptor::class, 'Mime-type of the file');
        $builder->add('size', IntegerDescriptor::class, 'Size of the file in bytes');
        $builder->add('encoding', StringDescriptor::class, 'Encoding of the file');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'file';
    }
}
