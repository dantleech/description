<?php

namespace Symfony\Cmf\Component\Description\Schema;

class Definition
{
    private $extensionClass;
    private $key;
    private $class;
    private $info;

    public function __construct(string $extensionClass, string $key, string $class, string $info)
    {
        $this->extensionClass = $extensionClass;
        $this->key = $key;
        $this->class = $class;
        $this->info = $info;
    }

    public function getExtensionClass(): string
    {
        return $this->extensionClass;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getInfo(): string
    {
        return $this->info;
    }
}
