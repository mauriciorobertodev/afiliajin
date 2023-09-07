<?php

use App\Actions\Update\UpdateHeadBottom;
use App\Models\Page;

test('Deve alterar o conteúdo de head bottom', function () {
    $page = Page::factory()->createOne();
    $tag  = config('app.head_bottom');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <link rel="stylesheet" href="custom.css">
    HTML;
    $html .= PHP_EOL . $tag;

    $page->head_bottom = '<link rel="stylesheet" href="custom_test.css">';

    $expected = $tag . PHP_EOL;
    $expected .= $page->head_bottom;
    $expected .= PHP_EOL . $tag;

    $result = UpdateHeadBottom::run($page, $html);

    expect($expected)->toBe($result);
});

test('Deve remover o conteúdo de head bottom', function () {
    $page = Page::factory()->createOne();
    $tag  = config('app.head_bottom');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <link rel="stylesheet" href="custom.css">
    HTML;
    $html .= PHP_EOL . $tag;

    $page->head_bottom = '';

    $expected = $tag . PHP_EOL . PHP_EOL . $tag;

    $result = UpdateHeadBottom::run($page, $html);

    expect($expected)->toBe($result);
});
