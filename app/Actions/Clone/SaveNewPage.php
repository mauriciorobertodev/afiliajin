<?php

namespace App\Actions\Clone;

use App\Models\Page;
use Throwable;

final class SaveNewPage
{
    public static function run(array $data): bool
    {
        try {
            $page          = new Page($data);
            $page->user_id = auth()->user()->id;

            return $page->save();
        } catch (Throwable $th) {
            return false;
        }
    }
}
