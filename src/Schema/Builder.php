<?php

namespace Psi\Component\Description\Schema;

use Psi\Component\Description\Schema\Definition;

class Builder
{
    private $extensionClass;
    private $definitions = [];

    public function __construct($extensionClass)
    {
        $this->extensionClass = $extensionClass;
    }

    public function add($key, $descriptorClass, $info)
    {
        $definition = new Definition($this->extensionClass, $key, $descriptorClass, $info);
        $this->definitions[] = $definition;
    }

    public function getDefinitions(): array
    {
        return $this->definitions;
    }
}
