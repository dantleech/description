<?php

declare(strict_types=1);

namespace Psi\Component\Description;

use Psi\Component\Description\Schema\Schema;


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
}
