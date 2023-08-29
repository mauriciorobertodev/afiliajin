<?php

use App\Actions\Clone\FormatPageContent;

test('Deve o mínimo de espaços vazios possível, de mudar os links relativos pra o site clonado e quebrar as linhas ao fechar as tags', function () {
    $content = <<<'HTML'
        <a href="http://test.com.br/test" />
        <a href="https://test.com.br/test" />
        <img src="http://test.com.br/test" />
        <img src="https://test.com.br/test" />
        <a href="./test" />
        <a href="./../test" />
        <a href="../test" />
        <a href="/test" />
        <img src="./test" />
        <img src="./../test" />
        <img src="../test" />
        <img src="/test" />
        <a HREF="./test" />
        <a HREF="./../test" />
        <a HREF="../test" />
        <a HREF="/test" />
        <img SRC="./test" />
        <img SRC="./../test" />
        <img SRC="../test" />
        <img SRC="/test" />
        <a href="
        ./test" />
        <a href="./../test
        " />
        <a href=
        "../test" />
        <a href="/test"
         />
        <img src="
        ./test" />
        <img src="./../test
        " />
        <img src=
        "../test" />
        <img src="/test"
        />
        <a     href  =   "./test"   />
        <img     src=   "./test"   />
        <a class="bg-test-500 text-test-500" href="./test?test=test&test2=test2#test" />
        <img class="bg-test-500 text-test-500" src="./test.png" />
        <img class="bg-test-500 text-test-500" src="./../test.png" />
    HTML;

    $expected = <<<'HTML'
    <a href="http://test.com.br/test" />
    <a href="https://test.com.br/test" />
    <img src="http://test.com.br/test" />
    <img src="https://test.com.br/test" />
    <a href="//test.com.br/test" />
    <a href="//test.com.br/../test" />
    <a href="//test.com.br/test" />
    <a href="//test.com.br/test" />
    <img src="//test.com.br/test" />
    <img src="//test.com.br/../test" />
    <img src="//test.com.br/test" />
    <img src="//test.com.br/test" />
    <a HREF="//test.com.br/test" />
    <a HREF="//test.com.br/../test" />
    <a HREF="//test.com.br/test" />
    <a HREF="//test.com.br/test" />
    <img SRC="//test.com.br/test" />
    <img SRC="//test.com.br/../test" />
    <img SRC="//test.com.br/test" />
    <img SRC="//test.com.br/test" />
    <a href="//test.com.br/test" />
    <a href="//test.com.br/../test " />
    <a href="//test.com.br/test" />
    <a href="//test.com.br/test" />
    <img src="//test.com.br/test" />
    <img src="//test.com.br/../test " />
    <img src="//test.com.br/test" />
    <img src="//test.com.br/test" />
    <a href="//test.com.br/test" />
    <img src="//test.com.br/test" />
    <a class="bg-test-500 text-test-500" href="//test.com.br/test?test=test&test2=test2#test" />
    <img class="bg-test-500 text-test-500" src="//test.com.br/test.png" />
    <img class="bg-test-500 text-test-500" src="//test.com.br/../test.png" />
    HTML;

    $result = FormatPageContent::run('test.com.br/', $content);

    expect(trim($expected))->toBe(trim($result));
});

test('Deve detectar se a página faz uso da fonte awesome e definir na tag head uma font que não causa problemas, também deve adicionar as tags pra códigos do usuário', function () {
    $content = <<<'HTML'
        <!DOCTYPE html>
        <html lang="pt-br">
            <head>
                <title>HTML TEST</title>
                <link rel="stylesheet" id="elementor-awesome" href="https://test.com.br/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.15.3" media="all" />
            </head>
            <body>
                <div> TEST </div>
            </body>
        </html>
    HTML;

    $expected = <<<'HTML'
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
    HTML . PHP_EOL .
    config('app.head_top_tag_start') . PHP_EOL .
    config('app.head_top_tag_end') . PHP_EOL .
    <<<'HTML'
    <title>HTML TEST</title>
    <link rel="stylesheet" id="elementor-awesome" href="https://test.com.br/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.15.3" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    HTML . PHP_EOL .
    config('app.head_bottom_tag_start') . PHP_EOL .
    config('app.head_bottom_tag_end') . PHP_EOL .
    <<<'HTML'
    </head>
    <body>
    HTML . PHP_EOL .
    config('app.body_top_tag_start') . PHP_EOL .
    config('app.body_top_tag_end') . PHP_EOL .
    <<<'HTML'
    <div> TEST </div>
    HTML . PHP_EOL .
    config('app.body_bottom_tag_start') . PHP_EOL .
    config('app.body_bottom_tag_end') . PHP_EOL .
    <<<'HTML'
    </body>
    </html>
    HTML;

    $result = FormatPageContent::run('test.com.br/', $content);
    // dd($expected, $result);

    expect(trim($expected))->toBe(trim($result));

});
