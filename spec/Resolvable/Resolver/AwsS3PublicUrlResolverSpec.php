<?php

namespace spec\Gaufrette\Extras\Resolvable\Resolver;

use Aws\S3\S3Client;
use Gaufrette\Extras\Resolvable\Resolver\AwsS3PublicUrlResolver;
use Gaufrette\Extras\Resolvable\ResolverInterface;
use PhpSpec\ObjectBehavior;

class AwsS3PublicUrlResolverSpec extends ObjectBehavior
{
    function let(S3Client $service)
    {
        $this->beConstructedWith($service, 'bucket', 'base/dir/');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AwsS3PublicUrlResolver::class);
    }

    function it_is_a_resolver()
    {
        $this->shouldImplement(ResolverInterface::class);
    }

    function it_resolves_object_path_to_public_url($service)
    {
        $service->getObjectUrl('bucket', 'base/dir/foo.png')->willReturn('https://amazon');

        $this->resolve('/foo.png')->shouldReturn('https://amazon');
    }
}
