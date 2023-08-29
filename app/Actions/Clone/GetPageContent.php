<?php

namespace App\Actions\Clone;

use Illuminate\Support\Facades\Http;
use Throwable;

final class GetPageContent
{
    public static function run(string $url): string | null
    {
        try {
            return Http::get($url)->body();
        } catch (Throwable $th) {
            return null;
        }
    }
}
