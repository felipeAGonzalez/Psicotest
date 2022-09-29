<?php

namespace App\Exceptions;

use App\Helpers\Lang;
use Illuminate\Support\MessageBag;

class FieldsException extends ObjectException
{
    public function __construct($message, $code = 422)
    {
        if ($message instanceof MessageBag) {
            $message = $this->parseMessageBag($message);
        }

        parent::__construct(['fields' => $message], $code);
    }

    private function parseMessageBag($bag)
    {
        $parse = [];
        foreach ($bag->toArray() as $key => $value) {
            $parse[$key] = [];
            foreach ($value as $k => $v) {
                $parse[$key][$k] = Lang::parse($v);
            }
        }

        return $parse;
    }
}
