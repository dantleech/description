<?php

namespace Psi\Component\Description\Tests\Unit\Schema\Extension;

use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\Schema\ExtensionInterface;
use Psi\Component\Description\Description;
use Psi\Component\Description\Schema\Schema;
use Psi\Component\Description\ValidatedDescription;

class ExtensionTestCase extends \PHPUnit_Framework_TestCase
{
    protected function build(ExtensionInterface $extension): DescriptionInterface
    {
        $schema = new Schema([
            $extension,
        ]);
        $description = new ValidatedDescription(new Description(), $schema);

        return $description;
    }
}
