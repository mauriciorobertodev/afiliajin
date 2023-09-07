<?php

namespace App\Actions\Util;

final class GetContentBetween
{
    public static function run(string $tag, string $html): string
    {
        $content = '';

        $pattern = '/' . $tag . "([\s\S]*?)" . $tag . '/';
        if (preg_match($pattern, $html, $matches)) {
            $content = trim($matches[1]);
        }

        return $content;
    }
}
