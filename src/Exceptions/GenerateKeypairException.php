<?php

namespace Ypho\Exceptions;

use Throwable;

class GenerateKeypairException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
