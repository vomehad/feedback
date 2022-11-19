<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class BaseException extends Exception
{
    #[Pure]
    public function __construct($message = "", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
