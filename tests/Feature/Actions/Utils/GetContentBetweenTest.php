<?php

use App\Actions\Util\GetContentBetween;

test('Deve retornar o conteúdo que está entre a tag passada', function () {

    $html = <<<'HTML'
    <!-- BUH -->
    <div>
        TEST
    </div>
    <!-- BUH -->
    HTML;

    $expected = <<<'HTML'
    <div>
        TEST
    </div>
    HTML;

    $content = GetContentBetween::run('<!-- BUH -->', $html);

    expect($expected)->toBe($content);

    $html = <<<'HTML'
    <div>
        TEST
    </div>
    HTML;

    $expected = '';

    $content = GetContentBetween::run('<!-- BUH -->', $html);

    expect($expected)->toBe($content);

});
