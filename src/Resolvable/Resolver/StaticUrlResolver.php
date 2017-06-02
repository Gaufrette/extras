<?php

namespace Gaufrette\Extras\Resolvable\Resolver;

use Gaufrette\Extras\Resolvable\ResolverInterface;

/**
 * Resolves object path by prepending a static prefix.
 *
 * @author Albin Kerouanton <albin.kerouanton@knplabs.com>
 */
class StaticUrlResolver implements ResolverInterface
{
    /** @var string */
    private $prefix;

    /**
     * @param string $prefix
     */
    public function __construct($prefix)
    {
        $this->prefix = rtrim($prefix, '/');
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($path)
    {
        return $this->prefix . '/' . ltrim($path, '/');
    }
}
