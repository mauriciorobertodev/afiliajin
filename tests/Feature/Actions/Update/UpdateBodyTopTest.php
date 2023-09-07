<?php

use App\Actions\Update\UpdateBodyTop;
use App\Models\Page;

test('Deve alterar o conteúdo de body top', function () {
    $page = Page::factory()->createOne();
    $tag  = config('app.body_top');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <script src="https://custom.js"></script>
    HTML;
    $html .= PHP_EOL . $tag;

    $page->body_top = '<script src="https://custom_test.js"></script>';

    $expected = $tag . PHP_EOL;
    $expected .= $page->body_top;
    $expected .= PHP_EOL . $tag;

    $result = UpdateBodyTop::run($page, $html);

    expect($expected)->toBe($result);
});

test('Deve remover o conteúdo de body top', function () {
    $page = Page::factory()->createOne();
    $tag  = config('app.body_top');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <script src="https://custom.js"></script>
    HTML;
    $html .= PHP_EOL . $tag;

    $page->body_top = '';

    $expected = $tag . PHP_EOL . PHP_EOL . $tag;

    $result = UpdateBodyTop::run($page, $html);

    expect($expected)->toBe($result);
});
