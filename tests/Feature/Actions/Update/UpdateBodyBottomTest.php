<?php

use App\Actions\Update\UpdateBodyBottom;
use App\Models\Page;

test('Deve alterar o conteúdo de body bottom', function () {
    $page = Page::factory()->createOne();
    $tag  = config('app.body_bottom');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <script src="https://custom.js"></script>
    HTML;
    $html .= PHP_EOL . $tag;

    $page->body_bottom = '<script src="https://custom_test.js"></script>';

    $expected = $tag . PHP_EOL;
    $expected .= $page->body_bottom;
    $expected .= PHP_EOL . $tag;

    $result = UpdateBodyBottom::run($page, $html);

    expect($expected)->toBe($result);
});

test('Deve remover o conteúdo de body bottom', function () {
    $page = Page::factory()->createOne();
    $tag  = config('app.body_bottom');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <script src="https://custom.js"></script>
    HTML;
    $html .= PHP_EOL . $tag;

    $page->body_bottom = '';

    $expected = $tag . PHP_EOL . PHP_EOL . $tag;

    $result = UpdateBodyBottom::run($page, $html);

    expect($expected)->toBe($result);
});
