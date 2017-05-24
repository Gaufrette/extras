<?php

namespace Gaufrette\Extras\Tests\Resolvable\Resolver;

use Gaufrette\Extras\Resolvable\ResolvableFilesystem;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @return ResolvableFilesystem Should return a decorated filesystem
     */
    abstract protected function getFilesystem();

    public function testWithExistingFile()
    {
        $filesystem = $this->getFilesystem();

        $filesystem->write('foo/bar', '');
        $this->assertNotEmpty($filesystem->resolve('foo/bar'));
    }

    public function testWithNonExistentFile()
    {
        $filesystem = $this->getFilesystem();

        $this->assertNotEmpty($filesystem->resolve('baz'));
    }
}
