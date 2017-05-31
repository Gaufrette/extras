<?php

namespace Gaufrette\Extras\Tests\Resolvable\Resolver;

use Gaufrette\Adapter\AwsS3;
use Gaufrette\Extras\Resolvable\ResolvableFilesystem;
use Gaufrette\Extras\Resolvable\Resolver\AwsS3PresignedUrlResolver;
use Gaufrette\Filesystem;

class AwsS3PresignedUrlResolverTest extends TestCase
{
    use AwsS3SetUpTearDownTrait;

    protected function getFilesystem()
    {
        $expiresAt = new \DateTime('+1 minute');

        return new ResolvableFilesystem(
            new Filesystem(new AwsS3($this->client, $this->bucket, ['create' => true])),
            new AwsS3PresignedUrlResolver($this->client, $this->bucket, '', $expiresAt)
        );
    }
}
