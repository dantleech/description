<?php

namespace Symfony\Cmf\Component\Description\Descriptor;

abstract class ScalarDescriptor
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
