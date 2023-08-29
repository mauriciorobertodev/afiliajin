<?php

namespace App\Actions\Clone;

final class FormatPageContent
{
    public static function run(string $cloned_from, string $content): string
    {
        // concertando os links relativos a path
        $pattern = "/(href|src)\s*=\s*[\"']\s*(?:\.\/|\/|\.\.\/)(\w*\s*[^\"']+)[\"']/i";
        $content = preg_replace($pattern, '$1="//' . $cloned_from . '$2"', $content);

        // detectando se usa font awesome e definindo uma fonte free sem erro
        $pattern = "/(font([-_\s]+)awesome|fontawesome)/i";
        if (preg_match_all($pattern, $content)) {
            $font    = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
            $content = preg_replace('/([<]\s*\/\s*head\s*[>])/', $font . '$1', $content);
        }

        // colocando as tags que ficará códigos do usuário
        $content = preg_replace('/([<]\s*head\s*[>])/', '<head>' . config('app.head_top_tag_start') . config('app.head_top_tag_end'), $content);
        $content = preg_replace('/([<]\s*\/\s*head\s*[>])/', config('app.head_bottom_tag_start') . config('app.head_bottom_tag_end') . '</head>', $content);
        $content = preg_replace('/([<]\s*body.*[>])/', '$1' . config('app.body_top_tag_start') . config('app.body_top_tag_end'), $content);
        $content = preg_replace('/([<]\s*\/\s*body\s*[>])/', config('app.body_bottom_tag_start') . config('app.body_bottom_tag_end') . '</body>', $content);

        // diminuindo o máximo de espaços em branco
        $content = preg_replace("/(\s+)/", ' ', $content);

        // quebrando a linha entre as tags
        $content = preg_replace('/(\>\s*\<|\>\<)/', ">\n<", $content);

        return trim($content);
    }
}
