<?php

namespace App\Actions\Update;

use App\Models\Page;

final class UpdateCookie
{
    public static function run(Page $page, string $html): string
    {
        if ($page->isDirty('cookie')) {
            $cookie      = $page->cookie ? '<iframe src="' . $page->cookie . '" style="width:0;height:0;border:0; border:none;"></iframe>' : '';
            $pattern     = '/(' . config('app.cookie') . "[\s\S]*?" . config('app.cookie') . ')/';
            $replacement = config('app.cookie') . "\n" . $cookie . "\n" . config('app.cookie');
            $html        = preg_replace($pattern, $replacement, $html);
        }

        return $html;
    }
}
