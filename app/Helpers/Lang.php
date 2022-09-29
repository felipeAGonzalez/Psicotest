<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Lang as LangFacades;

class Lang
{
    public static function get($key, $args = [])
    {
        $lang = LangFacades::get($key, $args);
        if ($lang == $key) {
            throw new Exception('Message not declared in lang files '.$key);
        }

        return self::parse($lang);
    }

    public static function parse($text)
    {
        $code = preg_replace('/.*\#([A-Za-z0-9]+)\#.*/', '${1}', $text);

        $expression = $text;
        $expression = preg_replace('/\#[A-Za-z0-9]+\#/', '', $expression);
        $expression = preg_replace('/\{([A-Za-z0-9-_]+):[A-Za-z0-9-_ .,]+\}/', '{${1}}', $expression);

        $args = [];
        $matches = [];
        preg_match_all('/\{([A-Za-z0-9-_]+):([A-Za-z0-9-_ .,]*)\}/', $text, $matches);
        if (count($matches) >= 3) {
            foreach (array_keys($matches[0]) as $key) {
                $args[$matches[1][$key]] = $matches[2][$key];
            }
        }

        $message = $text;
        $message = preg_replace('/\#[A-Za-z0-9]+\#/', '', $message);
        $message = preg_replace('/\{[A-Za-z0-9-_]+:([A-Za-z0-9-_ .,]*)\}/', '${1}', $message);

        return [
            'message' => $message,
            'code' => $code,
            'expression' => $expression,
            'args' => $args,
        ];
    }
}
