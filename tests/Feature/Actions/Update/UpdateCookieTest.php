<?php

use App\Actions\Update\UpdateCookie;
use App\Models\Page;

test('Deve alterar o iframe do cookie', function () {
    $page = Page::factory()->createOne();

    $html = config('app.cookie') . PHP_EOL;
    $html .= <<<'HTML'
    <iframe src="https://google.com" style="width:0;height:0;border:0; border:none;"></iframe>
    HTML;
    $html .= PHP_EOL . config('app.cookie');

    $page->cookie = 'https://go.hotmart.com.br';

    $expected = config('app.cookie') . PHP_EOL;
    $expected .= <<<'HTML'
    <iframe src="https://go.hotmart.com.br" style="width:0;height:0;border:0; border:none;"></iframe>
    HTML;
    $expected .= PHP_EOL . config('app.cookie');

    $result = UpdateCookie::run($page, $html);

    expect($expected)->toBe($result);
});

test('Deve remover o iframe do cookie', function () {
    $page = Page::factory()->createOne();

    $html = config('app.cookie') . PHP_EOL;
    $html .= <<<'HTML'
    <iframe src="https://google.com" style="width:0;height:0;border:0; border:none;"></iframe>
    HTML;
    $html .= PHP_EOL . config('app.cookie');

    $page->cookie = '';

    $expected = config('app.cookie') . PHP_EOL;
    $expected .= PHP_EOL . config('app.cookie');

    $result = UpdateCookie::run($page, $html);

    expect($expected)->toBe($result);
});
