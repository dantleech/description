<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Component\Description;

use Puli\Repository\Api\Object\PuliObject;

class DescriptionFactory
{
    /**
     * @var DescriptionEnhancerInterface[]
     */
    private $enhancers = [];

    /**
     * @param array $enhancers
     */
    public function __construct(array $enhancers)
    {
        $this->enhancers = $enhancers;
    }

    /**
     * Return a description of the given (CMF) Object.
     *
     * @param object $object
     *
     * @return Description
     */
    public function getPayloadDescriptionFor($object)
    {
        $description = new Description($object);

        foreach ($this->enhancers as $enhancer) {
            if (false === $enhancer->supports($description)) {
                continue;
            }

            $enhancer->enhance($description);
        }

        return $description;
    }
}
