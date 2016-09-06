<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psi\Component\Description;

use Psi\Component\Description\Schema\Schema;
use Psi\Component\Description\DescriptorInterface;
use Psi\Component\Description\Descriptor\ScalarDescriptor;
use Psi\Component\Description\DescriptionInterface;

/**
 * Decorator for description which validates the descriptions based
 * on the given Schema.
 *
 * Note that for performance reasons this should only be used in a development
 * environemnt.
 */
class ValidatedDescription implements DescriptionInterface
{
    /**
     * @var Description
     */
    private $description;

    /**
     * @var Scehma
     */
    private $schema;

    public function __construct(DescriptionInterface $description, Schema $schema)
    {
        $this->description = $description;
        $this->schema = $schema;
    }

    /**
     * {@inheritdoc}
     */
    public function get($descriptorKey): DescriptorInterface
    {
        $this->schema->validateKey($descriptorKey);

        return $this->description->get($descriptorKey);
    }

    /**
     * {@inheritdoc}
     */
    public function has($descriptor): bool
    {
        $this->schema->validateKey($descriptor);

        return $this->description->has($descriptor);
    }

    /**
     * {@inheritdoc}
     */
    public function all(): array
    {
        return $this->description->all();
    }

    /**
     * {@inheritdoc}
     */
    public function set(DescriptorInterface $descriptor)
    {
        $this->schema->validate($descriptor);
        $this->description->set($descriptor);
    }

    /**
     * Return the object for which this is the description.
     *
     * @return object
     */
    public function getObject()
    {
        return $this->description->getObject();
    }
}
