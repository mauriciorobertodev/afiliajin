<?php

namespace App\Actions\Update;

use App\Models\Page;

final class UpdateWhatsappButton
{
    public static function run(Page $page, string $html): string
    {
        if ($page->isDirty(['whatsapp_show', 'whatsapp_number', 'whatsapp_message'])) {
            $pattern         = '/(' . config('app.whatsapp') . "[\s\S]*?" . config('app.whatsapp') . ')/';
            $whatsapp_link   = 'https://api.whatsapp.com/send?phone=' . $page->whatsapp_number . ($page->whatsapp_message ? '&text=' . $page->whatsapp_message : '');
            $whatsapp_button = str_replace('{{ LINK }}', $whatsapp_link, file_get_contents(app_path('stubs/whatsapp_button.html')));
            $replacement     = config('app.whatsapp') . "\n" . ($page->whatsapp_show ? $whatsapp_button : '') . "\n" . config('app.whatsapp');
            $html            = preg_replace($pattern, $replacement, $html);
        }

        return $html;
    }
}
