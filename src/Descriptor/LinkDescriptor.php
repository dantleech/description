<?php

namespace Symfony\Cmf\Component\Description\Descriptor;

class LinkDescriptor
{
    private $link;
    private $key;

    public function __construct(string $key, string $link)
    {
        $this->link = $link;
        $this->key = $key;
    }

    public function getKey() 
    {
        return $this->key;
    }
    

    public function getLink()
    {
        return $this->link;
    }
}
