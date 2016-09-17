<?php

declare(strict_types=1);

namespace Psi\Component\Description;

use Psi\Component\Description\Schema\Schema;

/**
 * This class is the main point of entry for this component.
 *
 * It provides descriptions for objects.
 */
class DescriptionFactory
{
    /**
     * @var DescriptionEnhancerInterface[]
     */
    private $enhancers = [];

    /**
     * @var Schema
     */
    private $schema;

    /**
     * @param array $enhancers
     */
    public function __construct(array $enhancers, Schema $schema = null)
    {
        $this->enhancers = $enhancers;
        $this->schema = $schema;
    }

    /**
     * Return a description of the given subject.
     *
     * @param object|string $objectOrClass
     *
     * @return Description
     */
    public function describe(Subject $subject): DescriptionInterface
    {
        $description = $this->createDescription();

        foreach ($this->enhancers as $enhancer) {
            if (false === $enhancer->supports($subject)) {
                continue;
            }

            $enhancer->enhanceFromClass($description, $subject->getClass());

            if ($subject->hasObject()) {
                $enhancer->enhanceFromObject($description, $subject);
            }
        }

        return $description;
    }

    private function createDescription(): DescriptionInterface
    {
        $description = new Description();

        if ($this->schema) {
            $description = new ValidatedDescription($description, $this->schema);
        }

        return $description;
    }
}
