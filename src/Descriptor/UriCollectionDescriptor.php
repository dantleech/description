<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class UriCollectionDescriptor implements DescriptorInterface, \IteratorAggregate
{
    private $uris;
    private $key;

    public function __construct(string $key, array $uris)
    {
        $this->uris = $uris;
        $this->key = $key;
    }

    /**
     * Return an array of URIs. Note that the keys
     * CAN be the class FQN of the object to which the URI
     * is related.
     */
    public function getValues(): array
    {
        return $this->uris;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->uris);
    }
}
