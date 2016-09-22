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

        $description->set('std.class', new ClassDescriptor(new \ReflectionClass(\stdClass::class)));
        $description->set('std.class.alias', new StringDescriptor('std'));
        $description->set('std.title', new StringDescriptor('Foobar'));
        $description->set('std.description', new StringDescriptor('All about foobar'));
        $description->set('std.image', new UriDescriptor('https://example.com/edit/123'));
        $description->set('std.created_at', new DateTimeDescriptor(new \DateTime()));
        $description->set('std.updated_at', new DateTimeDescriptor(new \DateTime()));

        $description->set('std.uri.create', new UriDescriptor('https://example.com/edit/123'));
        $description->set('std.uri.show', new UriDescriptor('https://example.com/edit/123'));
        $description->set('std.uri.update', new UriDescriptor('https://example.com/edit/123'));
        $description->set('std.uri.delete', new UriDescriptor('https://example.com/edit/123'));
        $description->set('std.uri.list', new UriDescriptor('https://example.com/edit/123'));
    }
}
