<?php

namespace Psi\Component\Description\Schema;

use Psi\Component\Description\Schema\Builder;
use Psi\Component\Description\Schema\ExtensionInterface;
use Psi\Component\Description\DescriptorInterface;

/**
 * Description schema.
 */
class Schema
{
    private $definitions;

    public function register(ExtensionInterface $extension)
    {
        $builder = new Builder(get_class($extension));
        $extension->buildSchema($builder);

        foreach ($builder->getDefinitions() as $definition) {
            if (isset($this->definitions[$definition->getKey()])) {
                throw new \InvalidArgumentException(sprintf(
                    'Descriptor key "%s" for was already registered by "%s" extension',
                    $definition->getKey(), $this->definitions[$definition->getKey()]->getExtensionClass()
                ));
            }

            $this->definitions[$definition->getKey()] = $definition;
        }
    }

    public function validateKey($key)
    {
        if (false === isset($this->definitions[$key])) {
            throw new \InvalidArgumentException(sprintf(
                'Descriptor "%s" not a permitted descriptor key. Did you make a typo? Permitted descriptors: "%s"',
                $key,
                implode('", "', array_keys($this->definitions))
            ));
        }
    }

    public function validate(DescriptorInterface $descriptor)
    {
        $this->validateKey($descriptor->getKey());
        $definition = $this->definitions[$descriptor->getKey()];

        if (get_class($descriptor) !== $definition->getClass()) {
            throw new \InvalidArgumentException(sprintf(
                'Descriptor with key "%s" must be of class "%s", got "%s"',
                $descriptor->getKey(),
                $definition->getClass(),
                get_class($descriptor)
            ));
        }
    }
}
