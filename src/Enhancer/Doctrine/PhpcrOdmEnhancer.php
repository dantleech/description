<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Component\Description\Enhancer\Doctrine;

use Symfony\Cmf\Component\Description\DescriptionEnhancerInterface;
use Symfony\Cmf\Component\Description\Description;
use Puli\Repository\Api\Resource\PuliResource;
use Symfony\Cmf\Component\Description\Descriptor;
use Doctrine\ODM\PHPCR\Mapping\ClassMetadataFactory;
use Doctrine\Common\Util\ClassUtils;

/**
 * Add descriptors from the Doctrine PHPCR ODM.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PhpcrOdmEnhancer implements DescriptionEnhancerInterface
{
    private $metadataFactory;

    public function __construct(ClassMetadataFactory $metadataFactory)
    {
        $this->metadataFactory = $metadataFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function enhance(Description $description)
    {
        $object = $description->getObject();
        $metadata = $this->metadataFactory->getMetadataFor(ClassUtils::getRealClass(get_class($object)));
        $childClasses = $metadata->getChildClasses();
        $childTypes = [];

        // explode the allowed types into concrete classes
        foreach ($this->metadataFactory->getAllMetadata() as $childMetadata) {
            foreach ($childClasses as $childClass) {
                if ($childClass == $childMetadata->name || $childMetadata->getReflectionClass()->isSubclassOf($childClass)) {
                    $childTypes[] = $childMetadata->name;
                }
            }
        }

        $description->set(Descriptor::CHILDREN_ALLOW, !$metadata->isLeaf());
        $description->set(Descriptor::CHILDREN_TYPES, $childTypes);
        $description->set(Descriptor::CLASS_FQN, ClassUtils::getRealClass($description->get(Descriptor::CLASS_FQN)));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Description $description)
    {
        return $this->metadataFactory->hasMetadataFor(ClassUtils::getRealClass($description->get(Descriptor::CLASS_FQN)));
    }
}
