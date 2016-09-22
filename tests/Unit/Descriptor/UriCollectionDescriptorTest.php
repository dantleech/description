<?php

declare(strict_types=1);

namespace Psi\Component\Description\Tests\Unit\Descriptor;

use Psi\Component\Description\Descriptor\UriCollectionDescriptor;

class UriCollectionDescriptorTest extends \PHPUnit_Framework_TestCase
{
    private $descriptor;

    public function setUp()
    {
        $this->descriptor = new UriCollectionDescriptor([
            'foo' => 'https://foobar.com/admin/edit/123',
        ]);
    }

    public function testGetValue()
    {
        $uris = iterator_to_array($this->descriptor);
        $this->assertCount(1, $uris);
        $this->assertArrayHasKey('foo', $uris);
        $this->assertEquals('https://foobar.com/admin/edit/123', $uris['foo']);
    }
}
