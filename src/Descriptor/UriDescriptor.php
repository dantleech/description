<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class UriDescriptor implements DescriptorInterface
{
    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Return the URI string.
     */
    public function getValue(): string
    {
        return $this->uri;
    }
}
