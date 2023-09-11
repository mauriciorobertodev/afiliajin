<?php

use App\Actions\Util\GetLinks;

test('Deve pegar todas as tags img', function () {
    $content = <<<'HTML'
        <img src="https://test.com.br/test.png" />
        <img src="//test.com.br/test2.webp" />
        <img src="https://test.com.br/test3.jpg" />
    HTML;

    $expected = [
        'videos'    => [],
        'images'    => [
            'https://test.com.br/test.png',
            '//test.com.br/test2.webp',
            'https://test.com.br/test3.jpg',
        ],
        'checkouts' => [],
        'links'     => [],
    ];

    $result = GetLinks::run( $content);

    expect($expected)->toBe($result);
});

test('Deve pegar todos os videos', function () {
    $content = <<<'HTML'
        <iframe width="1280" height="720" src="https://www.youtube.com/embed/l26kR9WAhE8" title="SUPER XANDÃO REAGINDO AS COISAS BIZARRAS DO MUNDO" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        <iframe src="https://player.vimeo.com/video/858545682?h=6bad42a512" width="640" height="386" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        <iframe src="https://batata.com/video/858545682?h=6bad42a512" width="640" height="386" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        <iframe width="1280" height="720" src="https://www.tomate.com/embed/l26kR9WAhE8" title="SUPER XANDÃO REAGINDO AS COISAS BIZARRAS DO MUNDO" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    HTML;

    $expected = [
        'videos'    => [
            'https://www.youtube.com/embed/l26kR9WAhE8',
            'https://player.vimeo.com/video/858545682?h=6bad42a512',
        ],
        'images'    => [],
        'checkouts' => [],
        'links'     => [],
    ];

    $result = GetLinks::run($content);

    expect($expected)->toBe($result);
});

test('Deve pegar todos os links', function () {
    $content = <<<'HTML'
        <a href="https://test.com.br/test01"></a>
        <a href="http://test.com.br/test02"></a>
        <a href="//test.com.br/test03"></a>
        <a href="//pay.hotmart.com/?ref=H879898989"></a>
        <a href="//pay.kiwify.com/?ref=H879898989"></a>
        <a href="//pay.monetizze.com/?ref=H879898989"></a>
    HTML;

    $expected = [
        'videos'    => [],
        'images'    => [],
        'checkouts' => [
            '//pay.hotmart.com/?ref=H879898989',
            '//pay.kiwify.com/?ref=H879898989',
            '//pay.monetizze.com/?ref=H879898989',
        ],
        'links'     => [
            'https://test.com.br/test01',
            'http://test.com.br/test02',
            '//test.com.br/test03',
        ],
    ];

    $result = GetLinks::run($content);

    expect($expected)->toBe($result);
});
