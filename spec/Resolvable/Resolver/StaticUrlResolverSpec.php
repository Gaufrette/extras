<?php

namespace spec\Gaufrette\Extras\Resolvable\Resolver;

use Gaufrette\Extras\Resolvable\Resolver\StaticUrlResolver;
use Gaufrette\Extras\Resolvable\ResolverInterface;
use PhpSpec\ObjectBehavior;

class StaticUrlResolverSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('https://google.com/');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StaticUrlResolver::class);
    }

    function it_is_a_resolver()
    {
        $this->shouldImplement(ResolverInterface::class);
    }

    function it_resolves_url_by_prepending_static_prefix_to_path()
    {
        $this->resolve('/foo.png')->shouldReturn('https://google.com/foo.png');
    }
}
