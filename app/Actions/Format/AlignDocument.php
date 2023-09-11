<?php

namespace App\Actions\Format;

final class AlignDocument
{
    public static function run(string $html): string
    {
        $html = preg_replace('/(\t+)/', ' ', $html);
        $html = preg_replace('/(\v+)/', "\n", $html);
        $html = preg_replace('/(\n+)/', "\n", $html);
        $html = preg_replace('/(\n\s+)/', "\n", $html);
        $html = preg_replace('/( +)/', ' ', $html);

        return trim($html);
    }
}
