<?php

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class LinkDescriptor implements DescriptorInterface
{
    private $link;
    private $key;

    public function __construct(string $key, string $link)
    {
        $this->link = $link;
        $this->key = $key;
    }

    public function getKey(): string
    {
        return $this->key;
    }
    

    public function getLink(): string
    {
        return $this->link;
    }
}
