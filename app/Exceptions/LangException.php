<?php

namespace App\Exceptions;

use App\Helpers\Lang;

class LangException extends ObjectException
{
    public function __construct($key, $args = [], $code = 422)
    {
        if (is_numeric($args)) {
            $code = $args;
            $args = [];
        }
        parent::__construct(Lang::get($key, $args), $code);
    }
}
