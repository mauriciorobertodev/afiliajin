<?php

namespace App\Actions\Update;

use App\Models\Page;

final class UpdateBodyTop
{
    public static function run(Page $page, string $html): string
    {
        if ($page->isDirty('body_top')) {
            $pattern     = '/(' . config('app.body_top') . "[\s\S]*?" . config('app.body_top') . ')/';
            $replacement = config('app.body_top') . "\n" . ($page->body_top ?? '') . "\n" . config('app.body_top');
            $html        = preg_replace($pattern, $replacement, $html);
        }

        return $html;
    }
}
