<?php

namespace App\Actions\Format;

final class PutHeadBottomTag
{
    public static function run(string $html): string
    {
        $tag     = config('app.head_bottom');
        $replace = PHP_EOL . $tag . PHP_EOL . $tag . PHP_EOL;

        return preg_replace('/([<]\s*\/\s*head\s*[>])/', $replace . '$1', $html);
    }
}
