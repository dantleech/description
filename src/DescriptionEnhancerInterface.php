<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psi\Component\Description;

interface DescriptionEnhancerInterface
{
    /**
     * Enrich the payload description.
     *
     * @param Description $description
     *
     * @return Description
     */
    public function enhance(Description $description);

    /**
     * Return true if the provider supports the given type.
     *
     * @param Description $description
     *
     * @return bool
     */
    public function supports(Description $description);
}
