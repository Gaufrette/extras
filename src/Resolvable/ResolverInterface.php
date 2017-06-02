<?php

namespace Gaufrette\Extras\Resolvable;

/**
 * Resolves an object path into an URI.
 *
 * @author Albin Kerouanton <albin.kerouanton@knplabs.com>
 */
interface ResolverInterface
{
    /**
     * Resolves an object path to an URI.
     *
     * @param string $path Object path
     *
     * @return string
     */
    public function resolve($path);
}
