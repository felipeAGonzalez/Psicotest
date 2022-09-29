<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Lang as LangFacades;

class Lang
{

    public static function get($key)
    {
        $lang = LangFacades::get($key);
        if ($lang == $key) {
            throw new Exception('Message not declared in lang files '.$key);
        }

        return $lang;
    }
}
