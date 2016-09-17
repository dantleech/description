<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class UriDescriptor implements DescriptorInterface
{
    private $uri;
    private $key;

    public function __construct(string $key, $uri)
    {
        $this->uri = $uri;
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Return the URI string.
     */
    public function getValue(): string
    {
        return $this->uri;
    }
}
