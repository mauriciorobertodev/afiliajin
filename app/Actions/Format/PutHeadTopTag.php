<?php

namespace App\Actions\Format;

final class PutHeadTopTag
{
    public static function run(string $html): string
    {
        $tag     = config('app.head_top');
        $replace = PHP_EOL . $tag . PHP_EOL . $tag . PHP_EOL;

        return preg_replace('/([<]\s*head\s*[>])/', '$1' . $replace, $html);
    }
}
