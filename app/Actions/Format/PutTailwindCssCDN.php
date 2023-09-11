<?php

namespace App\Actions\Format;

final class PutTailwindCssCDN
{
    public static function run(string $html): string
    {
        $replace = PHP_EOL . '<script src="https://cdn.tailwindcss.com"></script>' . PHP_EOL;

        return preg_replace('/([<]\s*\/\s*head\s*[>])/', $replace . '$1', $html);

    }
}
