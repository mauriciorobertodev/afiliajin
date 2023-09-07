<?php

namespace App\Actions\Update;

use App\Models\Page;

final class UpdateHeadBottom
{
    public static function run(Page $page, string $html): string
    {
        if ($page->isDirty('head_bottom')) {
            $pattern     = '/(' . config('app.head_bottom') . "[\s\S]*?" . config('app.head_bottom') . ')/';
            $replacement =  config('app.head_bottom') . "\n" . ($page->head_bottom ?? '') . "\n" . config('app.head_bottom');
            $html        = preg_replace($pattern, $replacement, $html);
        }

        return $html;
    }
}
