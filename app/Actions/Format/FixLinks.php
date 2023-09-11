<?php

namespace App\Actions\Format;

final class FixLinks
{
    public static function run(string $cloned_from, string $html): string
    {

        // concertando os links relativos a path
        $pattern = "/(href|src)\s*=\s*[\"']\s*(?:\.\/|\/)(\w*\s*[^\"']+)[\"']/i";
        $html    = preg_replace($pattern, '$1="//' . $cloned_from . '$2"', $html);

        // concertando os links relativos a path
        $pattern = "/(href|src)\s*=\s*[\"']\s*(?:\.\.\/)(\w*\s*[^\"']+)[\"']/i";

        return preg_replace($pattern, '$1="//' . $cloned_from . '../' . '$2"', $html);
    }
}
