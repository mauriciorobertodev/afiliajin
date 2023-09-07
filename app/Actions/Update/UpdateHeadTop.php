<?php

namespace App\Actions\Update;

use App\Models\Page;

final class UpdateHeadTop
{
    public static function run(Page $page, string $html): string
    {
        if ($page->isDirty('head_top')) {
            $pattern     =  '/(' . config('app.head_top') . "[\s\S]*?" . config('app.head_top') . ')/';
            $replacement =  config('app.head_top') . "\n" . ($page->head_top ?? '') . "\n" . config('app.head_top');
            $html        = preg_replace($pattern, $replacement, $html);
        }

        return $html;
    }
}
