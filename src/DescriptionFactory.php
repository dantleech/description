<?php

declare(strict_types=1);

namespace Psi\Component\Description;

use Psi\Component\Description\Schema\Schema;

/**
 * This class is the main point of entry for this component.
 *
 * It provides descriptions for objects. Descriptions are populated by
 * "enhancers" as given in the constructor. The order of the enhancers is important
 */
class DescriptionFactory
{
    /**
     * @var DescriptionEnhancerInterface[]
     */
    private $enhancers = [];

    /**
     * @var SubjectResolverInterface[]
     */
    private $resolvers = [];

    /**
     * @var Schema
     */
    private $schema;

    public function __construct(array $enhancers, array $resolvers = [], Schema $schema = null)
    {
        // type safety ...
        array_walk($enhancers, function (EnhancerInterface $enhancer) {
        });
        array_walk($resolvers, function (SubjectResolverInterface $enhancer) {
        });

        $this->enhancers = $enhancers;
        $this->resolvers = $resolvers;
        $this->schema = $schema;
    }

    /**
     * Return a description of the given subject.
     */
    public function describe(Subject $subject): DescriptionInterface
    {
        $description = $this->createDescription();

        foreach ($this->resolvers as $resolver) {
            $subject = $resolver->resolve($subject);
        }

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
