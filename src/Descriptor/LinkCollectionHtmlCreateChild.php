<?php

namespace Symfony\Cmf\Component\Description\Descriptor;

class LinkCollectionHtmlCreateChild implements \IteratorAggregate
{
    private $links;

    public function __construct(array $links)
    {
        $this->links = new \ArrayIterator($links);
    }

    public function getIterator()
    {
        return $this->links;
    }
}
