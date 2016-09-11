<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Schema\Extension;

use Psi\Component\Description\Schema\Extension\StandardExtension;
use Psi\Component\Description\Descriptor\UriDescriptor;
use Psi\Component\Description\Descriptor\StringDescriptor;
use Psi\Component\Description\Descriptor\DateTimeDescriptor;
use Psi\Component\Description\Descriptor\ClassDescriptor;

class StandardExtensionTest extends ExtensionTestCase
{
    public function testExtension()
    {
        $description = $this->build(new StandardExtension());

        $description->set(new ClassDescriptor('std.class', new \ReflectionClass(\stdClass::class)));
        $description->set(new StringDescriptor('std.class.alias', 'std'));
        $description->set(new StringDescriptor('std.title', 'Foobar'));
        $description->set(new StringDescriptor('std.description', 'All about foobar'));
        $description->set(new UriDescriptor('std.image', 'https://example.com/edit/123'));
        $description->set(new DateTimeDescriptor('std.created_at', new \DateTime()));
        $description->set(new DateTimeDescriptor('std.updated_at', new \DateTime()));

        $description->set(new UriDescriptor('std.uri.create', 'https://example.com/edit/123'));
        $description->set(new UriDescriptor('std.uri.show', 'https://example.com/edit/123'));
        $description->set(new UriDescriptor('std.uri.update', 'https://example.com/edit/123'));
        $description->set(new UriDescriptor('std.uri.delete', 'https://example.com/edit/123'));
        $description->set(new UriDescriptor('std.uri.list', 'https://example.com/edit/123'));
    }
}
