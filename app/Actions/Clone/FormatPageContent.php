<?php

namespace App\Actions\Clone;

use App\Actions\Format\AlignDocument;
use App\Actions\Format\FixLinks;
use App\Actions\Format\PutBodyBottomTag;
use App\Actions\Format\PutBodyTopTag;
use App\Actions\Format\PutCookieTag;
use App\Actions\Format\PutFontAwesome;
use App\Actions\Format\PutHeadBottomTag;
use App\Actions\Format\PutHeadTopTag;
use App\Actions\Format\PutTailwindCssCDN;
use App\Actions\Format\PutWhatsappButtonTag;

final class FormatPageContent
{
    public static function run(string $cloned_from, string $content): string
    {
        $content = FixLinks::run($cloned_from, $content);
        $content = PutFontAwesome::run($content);
        $content = PutTailwindCssCDN::run($content);
        $content = PutCookieTag::run($content);
        $content = PutWhatsappButtonTag::run($content);
        $content = PutHeadTopTag::run($content);
        $content = PutHeadBottomTag::run($content);
        $content = PutBodyTopTag::run($content);
        $content = PutBodyBottomTag::run($content);
        $content = AlignDocument::run($content);

        return $content;
    }
}
