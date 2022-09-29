<?php

namespace App\Exceptions;

use Exception;

class ObjectException extends Exception
{
    public function __construct($message, $code = 422)
    {
        $message = json_encode($message);
        parent::__construct($message, $code);
    }
}
