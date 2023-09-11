<?php

namespace App\Actions\Format;

final class PutBodyTopTag
{
    public static function run(string $html): string
    {
        $tag     = config('app.body_top');
        $replace = PHP_EOL . $tag . PHP_EOL . $tag . PHP_EOL;

        return preg_replace('/([<]\s*body[^>]*>)/', '$1' . $replace, $html);
    }
}
