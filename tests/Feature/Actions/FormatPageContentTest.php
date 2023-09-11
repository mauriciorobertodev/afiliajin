<?php

use App\Actions\Clone\FormatPageContent;

test('Deve o mínimo de espaços vazios possível, de mudar os links relativos pra o site clonado', function () {
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
    <a href="//test.com.br/../test" />
    <a href="//test.com.br/test" />
    <img src="//test.com.br/test" />
    <img src="//test.com.br/../test" />
    <img src="//test.com.br/../test" />
    <img src="//test.com.br/test" />
    <a HREF="//test.com.br/test" />
    <a HREF="//test.com.br/../test" />
    <a HREF="//test.com.br/../test" />
    <a HREF="//test.com.br/test" />
    <img SRC="//test.com.br/test" />
    <img SRC="//test.com.br/../test" />
    <img SRC="//test.com.br/../test" />
    <img SRC="//test.com.br/test" />
    <a href="//test.com.br/test" />
    <a href="//test.com.br/../test
    " />
    <a href="//test.com.br/../test" />
    <a href="//test.com.br/test"
    />
    <img src="//test.com.br/test" />
    <img src="//test.com.br/../test
    " />
    <img src="//test.com.br/../test" />
    <img src="//test.com.br/test"
    />
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

    $content = file_get_contents( base_path('/tests/html/normal_site.html'));

    $expected = preg_replace(
        ['/{{ HEAD_TOP }}/', '/{{ HEAD_BOTTOM }}/', '/{{ BODY_TOP }}/', '/{{ COOKIE }}/', '/{{ BODY_BOTTOM }}/', '/{{ WHATSAPP_BUTTON }}/'],
        [config('app.head_top'), config('app.head_bottom'), config('app.body_top'),  config('app.cookie'), config('app.body_bottom'), config('app.whatsapp')],
        file_get_contents(base_path('/tests/html/cloned_site.html'))
    );

    $result = FormatPageContent::run('test.com.br/', $content);

    expect(trim($expected))->toBe(trim($result));

});
