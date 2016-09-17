<?php

declare(strict_types=1);

namespace Psi\Component\Description\Schema;

/**
 * Interface for schema extensions.
 *
 * Schema extensions define which keys are valid, and which descriptor classes
 * are valid for which keys. They also provide short descriptions of the descriptors.
 */
interface ExtensionInterface
{
    /**
     * Build the schema by adding new valid descriptors.
     */
    public function buildSchema(Builder $builder);

    /**
     * Return the name of the extension.
     *
     * NOTE: This value will automatically be prepended to descriptor keys.
     */
    public function getName();
}
