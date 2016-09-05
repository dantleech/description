<?php

namespace Symfony\Cmf\Component\Description\Schema;

class SchemaFactory
{
    /**
     * @var ExtensionInterface[]
     */
    private $extensions;

    /**
     * @param array $extensions
     */
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }

    public function create(): Schema
    {
        $schema = new Schema();

        foreach ($this->extensions as $extension) {
            $schema->register($extension);
        }

        return $schema;
    }
}
