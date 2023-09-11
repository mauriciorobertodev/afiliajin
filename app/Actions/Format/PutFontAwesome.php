<?php

namespace App\Actions\Format;

final class PutFontAwesome
{
    public static function run(string $html): string
    {
        $pattern = "/(font([-_\s]+)awesome|fontawesome)/i";
        if (preg_match_all($pattern, $html)) {
            $font    = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
            $html    = preg_replace('/([<]\s*\/\s*head\s*[>])/', $font . '$1', $html);
        }

        return $html;
    }
}
