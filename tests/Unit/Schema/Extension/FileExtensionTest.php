<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Schema\Extension;

use Psi\Component\Description\Schema\Extension\FileExtension;
use Psi\Component\Description\Descriptor\IntegerDescriptor;
use Psi\Component\Description\Descriptor\StringDescriptor;

class FileExtensionTest extends ExtensionTestCase
{
    public function testExtension()
    {
        $description = $this->build(new FileExtension());
        $description->set('file.mime-type', new StringDescriptor('image/jpeg'));
        $description->set('file.size', new IntegerDescriptor(128));
        $description->set('file.encoding', new StringDescriptor('binary'));
    }
}
