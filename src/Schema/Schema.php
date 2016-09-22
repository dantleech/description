<?php

declare(strict_types=1);

namespace Psi\Component\Description\Schema;

use Psi\Component\Description\DescriptorInterface;

/**
 * Description schema defines which descriptors are allowed to be
 * set on the description.
 */
class Schema
{
    private $definitions;

    public function __construct(array $extensions)
    {
        foreach ($extensions as $extension) {
            $this->register($extension);
        }
    }

    /**
     * Ensure that a given key is valid.
     *
     * This is called when the user attempts to access a descriptor.
     */
    public function validateKey(string $key)
    {
        if (false === isset($this->definitions[$key])) {
            throw new \InvalidArgumentException(sprintf(
                'Descriptor "%s" not a permitted descriptor key. Did you make a typo? Permitted descriptors: "%s"',
                $key,
                implode('", "', array_keys($this->definitions))
            ));
        }
    }

    /**
     * Validate the descriptor key AND ensures that the given
     * descriptor is of the correct type according to the schema.
     *
     * This is called when a descriptor is set on the description.
     */
    public function validate(string $key, DescriptorInterface $descriptor)
    {
        $this->validateKey($key);
        $definition = $this->definitions[$key];

        if (get_class($descriptor) !== $definition->getClass()) {
            throw new \InvalidArgumentException(sprintf(
                'Descriptor with key "%s" must be of class "%s", got "%s"',
                $key,
                $definition->getClass(),
                get_class($descriptor)
            ));
        }
    }

    /**
     * Return the schema definitions.
     *
     * @return Definition[]
     */
    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    public function getDefinition($key): Definition
    {
        if (!isset($this->definitions[$key])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown definition "%s"', $key
            ));
        }

        return $this->definitions[$key];
    }

    private function register(ExtensionInterface $extension)
    {
        $builder = new Builder(get_class($extension));
        $extension->buildSchema($builder);

        foreach ($builder->getDefinitions() as $definition) {
            $key = sprintf('%s.%s', $extension->getName(), $definition->getKey());

            if (isset($this->definitions[$key])) {
                throw new \InvalidArgumentException(sprintf(
                    'Descriptor key "%s" for was already registered by "%s" extension',
                    $key, $this->definitions[$key]->getExtensionClass()
                ));
            }

            $this->definitions[$key] = $definition;
        }
    }
}
