<?php

namespace spec\Gaufrette\Extras\Resolvable\Resolver;

use Aws\CommandInterface;
use Aws\S3\S3Client;
use Gaufrette\Extras\Resolvable\Resolver\AwsS3PresignedUrlResolver;
use Gaufrette\Extras\Resolvable\ResolverInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;

class AwsS3PresignedUrlResolverSpec extends ObjectBehavior
{
    function let(S3Client $client)
    {
        $this->beConstructedWith($client, 'bucket', '/base/dir/', new \DateTime('+12 hour'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AwsS3PresignedUrlResolver::class);
    }

    function it_is_a_resolver()
    {
        $this->shouldImplement(ResolverInterface::class);
    }
}
