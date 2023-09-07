<?php

use App\Actions\Update\UpdateHeadTop;
use App\Models\Page;

test('Deve alterar o conteúdo de head top', function () {
    $page = Page::factory()->createOne();
    $tag  = config('app.head_top');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <link rel="stylesheet" href="custom.css">
    HTML;
    $html .= PHP_EOL . $tag;

    $page->head_top = '<link rel="stylesheet" href="custom_test.css">';

    $expected = $tag . PHP_EOL;
    $expected .= $page->head_top;
    $expected .= PHP_EOL . $tag;

    $result = UpdateHeadTop::run($page, $html);

    expect($expected)->toBe($result);
});

test('Deve remover o conteúdo de head top', function () {
    $page = Page::factory()->createOne();
    $tag  = config('app.head_top');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <link rel="stylesheet" href="custom.css">
    HTML;
    $html .= PHP_EOL . $tag;

    $page->head_top = '';

    $expected = $tag . PHP_EOL . PHP_EOL . $tag;

    $result = UpdateHeadTop::run($page, $html);

    expect($expected)->toBe($result);
});
