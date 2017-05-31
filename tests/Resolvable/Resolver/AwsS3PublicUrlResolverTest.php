<?php

namespace Gaufrette\Extras\Tests\Resolvable\Resolver;

use Gaufrette\Adapter\AwsS3;
use Gaufrette\Extras\Resolvable\ResolvableFilesystem;
use Gaufrette\Extras\Resolvable\Resolver\AwsS3PublicUrlResolver;
use Gaufrette\Filesystem;

class AwsS3PublicUrlResolverTest extends TestCase
{
    use AwsS3SetUpTearDownTrait;

    protected function getFilesystem()
    {
        return new ResolvableFilesystem(
            new Filesystem(new AwsS3($this->client, $this->bucket, ['create' => true])),
            new AwsS3PublicUrlResolver($this->client, $this->bucket, '')
        );
    }
}
