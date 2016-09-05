<?php

namespace Symfony\Cmf\Component\Description\Descriptor;

use Symfony\Cmf\Component\Description\DescriptorInterface;

class ScalarDescriptor implements DescriptorInterface
{
    private $key;
    private $value;

    public function __construct($key, $value)
    {
        $this->value = $value;
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}
