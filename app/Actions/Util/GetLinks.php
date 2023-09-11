<?php

namespace App\Actions\Util;

final class GetLinks
{
    public static function run(string $content): array
    {
        $links = [
            'videos'    => [],
            'images'    => [],
            'checkouts' => [],
            'links'     => [],
        ];

        if (preg_match_all('/<img\s+[^>]*src=[\'|\"]([^\"|\']*)[\'|\"][^>]*>/i', $content, $matches)) {
            $links['images'] = [...array_unique($matches[1])];
        }

        if (preg_match_all('/<iframe\s+[^>]*src=[\'|\"]([^\"|\']*(?:vimeo|youtube)[^\"|\']*)[\'|\"][^>]*>/i', $content, $matches)) {
            $links['videos'] = [...array_unique($matches[1])];
        }

        if (preg_match_all('/<a\s+[^>]*href=[\'|\"]([^\"|\']*)[\'|\"][^>]*>/i', $content, $matches)) {
            $matches[1] = [...array_unique($matches[1])];
            for ($i=0; $i < count($matches[1]); $i++) {
                $link = $matches[1][$i];
                if (preg_match('/.*(?:hotmart|kiwify|monetizze).*/i', $link)) {
                    $links['checkouts'][] = $link;
                } else {
                    $links['links'][] = $link;
                }
            }
        }

        return $links;
    }
}
