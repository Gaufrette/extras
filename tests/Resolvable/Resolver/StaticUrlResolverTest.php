<?php

namespace Gaufrette\Extras\Tests\Resolvable\Resolver;

use Gaufrette\Adapter\InMemory;
use Gaufrette\Extras\Resolvable\ResolvableFilesystem;
use Gaufrette\Extras\Resolvable\Resolver\StaticUrlResolver;
use Gaufrette\Filesystem;

class StaticUrlResolverTest extends TestCase
{
    protected function getFilesystem()
    {
        return new ResolvableFilesystem(
            new Filesystem(new InMemory()),
            new StaticUrlResolver('https://google.com')
        );
    }
}
