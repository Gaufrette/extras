<?php

namespace Gaufrette\Extras\Resolvable;

class UnresolvableObjectException extends \Exception
{
    /**
     * @param string          $path     Path of the unresolvable object
     * @param \Exception|null $previous Previous exception, if any
     */
    public function __construct($path, \Exception $previous = null)
    {
        parent::__construct($path, null, $previous);
    }
}
