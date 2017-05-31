<?php

namespace Gaufrette\Extras\Resolvable;

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
