<?php

namespace App\Actions\Update;

use App\Models\Page;

final class UpdateBodyBottom
{
    public static function run(Page $page, string $html): string
    {
        if ($page->isDirty('body_bottom')) {
            $pattern     = '/(' . config('app.body_bottom') . "[\s\S]*?" . config('app.body_bottom') . ')/';
            $replacement = config('app.body_bottom') . "\n" . ($page->body_bottom ?? '') . "\n" . config('app.body_bottom');
            $html        = preg_replace($pattern, $replacement, $html);
        }

        return $html;
    }
}
