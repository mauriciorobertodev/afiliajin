<?php

use App\Actions\Update\UpdateWhatsappButton;
use App\Models\Page;

test('Deve alterar o conteúdo do botão de whatsapp', function () {
    $page = Page::factory()->createOne([
        'whatsapp_show'    => true,
        'whatsapp_number'  => '88888888888',
        'whatsapp_message' => 'batata',
    ]);
    $tag  = config('app.whatsapp');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <div>whatsapp button</div>
    HTML;
    $html .= PHP_EOL . $tag;

    $page->whatsapp_number = '9999999999999';

    $whatsapp_link = 'https://api.whatsapp.com/send?phone=' . $page->whatsapp_number . '&text=' . $page->whatsapp_message;

    $expected = $tag . PHP_EOL;
    $expected .= str_replace('{{ LINK }}', $whatsapp_link, file_get_contents(app_path('stubs/whatsapp_button.html')));
    $expected .= PHP_EOL . $tag;

    $result = UpdateWhatsappButton::run($page, $html);

    expect($expected)->toBe($result);
});

test('Deve remover o conteúdo do botão de whatsapp', function () {
    $page = Page::factory()->createOne([
        'whatsapp_show' => true,
    ]);
    $tag  = config('app.whatsapp');

    $html = $tag . PHP_EOL;
    $html .= <<<'HTML'
    <div>whatsapp button</div>
    HTML;
    $html .= PHP_EOL . $tag;

    $page->whatsapp_show = false;

    $expected = $tag . PHP_EOL . PHP_EOL . $tag;

    $result = UpdateWhatsappButton::run($page, $html);

    expect($expected)->toBe($result);
});
