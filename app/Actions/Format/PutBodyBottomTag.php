<?php

namespace App\Actions\Format;

final class PutBodyBottomTag
{
    public static function run(string $html): string
    {
        $tag     = config('app.body_bottom');
        $replace = PHP_EOL . $tag . PHP_EOL . $tag . PHP_EOL;

        return preg_replace('/([<]\s*\/\s*body\s*[>])/', $replace . '$1', $html);
    }
}
