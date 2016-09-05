<?php

namespace Symfony\Cmf\Component\Description\Descriptor;

use Symfony\Cmf\Component\Description\DescriptorInterface;

class LinkCollectionDescriptor implements DescriptorInterface
{
    private $links;
    private $key;

    public function __construct(string $key, array $links)
    {
        $this->links = $links;
        $this->key = $key;
    }

    public function getLinks() 
    {
        return $this->links;
    }

    public function getKey() 
    {
        return $this->key;
    }
    
}
