<?php

namespace spec\Gaufrette\Extras\Resolvable;

use Gaufrette\Extras\Resolvable\ResolvableFilesystem;
use Gaufrette\Extras\Resolvable\ResolverInterface;
use Gaufrette\Extras\Resolvable\UnresolvableObjectException;
use Gaufrette\File;
use Gaufrette\FilesystemInterface;
use Gaufrette\Stream;
use PhpSpec\ObjectBehavior;

class ResolvableFilesystemSpec extends ObjectBehavior
{
    function let(MockedFilesystem $decorated, ResolverInterface $resolver)
    {
        $this->beConstructedWith($decorated, $resolver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ResolvableFilesystem::class);
    }

    function it_is_a_filesystem()
    {
        $this->shouldImplement(FilesystemInterface::class);
    }

    function it_resolves_object_path_into_uri($resolver)
    {
        $resolver->resolve('foo')->willReturn('https://yolo.com/my_image.png');
        $this->resolve('foo')->shouldReturn('https://yolo.com/my_image.png');
    }

    function it_throws_unresolvable_object_exception_if_any_error_happen_during_resolution($resolver)
    {
        $resolver->resolve('foo')->willThrow(\Exception::class);
        $this->shouldThrow(UnresolvableObjectException::class)->duringResolve('foo');
    }

    function it_delegates_has_to_decorated_filesystem($decorated)
    {
        $decorated->has('foo')->willReturn(true);
        $this->has('foo')->shouldReturn(true);
    }

    function it_delegates_rename_to_decorated_filesystem($decorated)
    {
        $decorated->rename('foo', 'bar')->willReturn(true);
        $this->rename('foo', 'bar')->shouldReturn(true);
    }

    function it_delegates_get_to_decorated_filesystem($decorated, File $file)
    {
        $decorated->get('foo', true)->willReturn($file);
        $this->get('foo', true)->shouldReturn($file);
    }

    function it_delegates_write_to_decorated_filesystem($decorated)
    {
        $decorated->write('foo', 'content', true)->willReturn(7);
        $this->write('foo', 'content', true)->shouldReturn(7);
    }

    function it_delegates_read_to_decorated_filesystem($decorated)
    {
        $decorated->read('foo')->willReturn('content');
        $this->read('foo')->shouldReturn('content');
    }

    function it_delegates_delete_to_decorated_filesystem($decorated)
    {
        $decorated->delete('foo')->willReturn(true);
        $this->delete('foo')->shouldReturn(true);
    }

    function it_delegates_keys_to_decorated_filesystem($decorated)
    {
        $decorated->keys()->willReturn(['foo', 'bar']);
        $this->keys()->shouldReturn(['foo', 'bar']);
    }

    function it_delegates_list_keys_to_decorated_filesystem($decorated)
    {
        $decorated->listKeys('aze/*')->willReturn(['keys' => ['foo', 'bar']]);
        $this->listKeys('aze/*')->shouldReturn(['keys' => ['foo', 'bar']]);
    }

    function it_delegates_mime_type_retrieval_to_decorated_filesystem($decorated)
    {
        $decorated->mtime('foo')->willReturn(123);
        $this->mtime('foo')->shouldReturn(123);
    }

    function it_delegates_checksum_computation_to_decorated_filesystem($decorated)
    {
        $decorated->checksum('foo')->willReturn('abcdef');
        $this->checksum('foo')->shouldReturn('abcdef');
    }

    function it_delegates_size_computation_to_decorated_filesystem($decorated)
    {
        $decorated->size('foo')->willReturn(123);
        $this->size('foo')->shouldReturn(123);
    }

    function it_delegates_stream_creation_to_decorated_filesystem($decorated, Stream $stream)
    {
        $decorated->createStream('foo')->willReturn($stream);
        $this->createStream('foo')->shouldReturn($stream);
    }

    function it_delegates_file_creation_to_decorated_filesystem($decorated, File $file)
    {
        $decorated->createFile('foo')->willReturn($file);
        $this->createFile('foo')->shouldReturn($file);
    }

    function it_delegates_mime_type_guessing_to_decorated_filesystem($decorated)
    {
        $decorated->mimeType('foo')->willReturn('application/json');
        $this->mimeType('foo')->shouldReturn('application/json');
    }

    function it_delegates_is_directory_to_delegated_filesystem($decorated)
    {
        $decorated->isDirectory('foo')->willReturn(false);
        $this->isDirectory('foo')->shouldReturn(false);
    }

    function it_delegates_any_other_method_call_to_decorated_filesystem($decorated)
    {
        $decorated->otherMethod()->shouldBeCalled();

        $this->otherMethod();
    }
}

interface MockedFilesystem extends FilesystemInterface {
    public function otherMethod();
}
