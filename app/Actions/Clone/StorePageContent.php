<?php

namespace App\Actions\Clone;

use Illuminate\Support\Facades\Storage;
use Throwable;

final class StorePageContent
{
    public static function run(string $slug, string $cloned): bool
    {
        try {
            return Storage::disk('pages')->put($slug . '.blade.php', $cloned);
        } catch (Throwable $th) {
            return false;
        }
    }
}
