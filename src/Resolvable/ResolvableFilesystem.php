<?php

namespace Gaufrette\Extras\Resolvable;

use Gaufrette\FilesystemInterface;

class ResolvableFilesystem implements FilesystemInterface
{
    /** @var FilesystemInterface */
    private $decorated;

    /** @var ResolverInterface */
    private $resolver;

    public function __construct(FilesystemInterface $decorated, ResolverInterface $resolver)
    {
        $this->decorated = $decorated;
        $this->resolver  = $resolver;
    }

    /**
     * @param string $key Object path.
     *
     * @throws UnresolvableObjectException When not able to resolve the object path. Any exception thrown by underlying
     *                                     resolver will be converted to this exception.
     *
     * @return string
     */
    public function resolve($key)
    {
        try {
            return $this->resolver->resolve($key);
        } catch (\Exception $e) {
            throw new UnresolvableObjectException($key, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return $this->decorated->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function rename($sourceKey, $targetKey)
    {
        return $this->decorated->rename($sourceKey, $targetKey);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $create = false)
    {
        return $this->decorated->get($key, $create);
    }

    /**
     * {@inheritdoc}
     */
    public function write($key, $content, $overwrite = false)
    {
        return $this->decorated->write($key, $content, $overwrite);
    }

    /**
     * {@inheritdoc}
     */
    public function read($key)
    {
        return $this->decorated->read($key);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        return $this->decorated->delete($key);
    }

    /**
     * {@inheritdoc}
     */
    public function keys()
    {
        return $this->decorated->keys();
    }

    /**
     * {@inheritdoc}
     */
    public function listKeys($prefix = '')
    {
        return $this->decorated->listKeys($prefix);
    }

    /**
     * {@inheritdoc}
     */
    public function mtime($key)
    {
        return $this->decorated->mtime($key);
    }

    /**
     * {@inheritdoc}
     */
    public function checksum($key)
    {
        return $this->decorated->checksum($key);
    }

    /**
     * {@inheritdoc}
     */
    public function size($key)
    {
        return $this->decorated->size($key);
    }

    /**
     * {@inheritdoc}
     */
    public function createStream($key)
    {
        return $this->decorated->createStream($key);
    }

    /**
     * {@inheritdoc}
     */
    public function createFile($key)
    {
        return $this->decorated->createFile($key);
    }

    /**
     * {@inheritdoc}
     */
    public function mimeType($key)
    {
        return $this->decorated->mimeType($key);
    }

    /**
     * {@inheritdoc}
     */
    public function isDirectory($key)
    {
        return $this->decorated->isDirectory($key);
    }

    /**
     * {@inheritdoc}
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->decorated, $name], $arguments);
    }
}
