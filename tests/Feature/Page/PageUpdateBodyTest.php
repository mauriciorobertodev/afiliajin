<?php

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

test('Deve redirecionar para tela de login caso o usuário não esteja logado', function () {
    $page = Page::factory()->createOne();

    put(route('page.update.body', ['id' => $page->id]))
        ->assertRedirectToRoute('login');
});

test('Deve retornar um 404 caso o usuário tente editar uma página que não existe ou não é dono', function () {
    $user = User::factory()->createOne();
    $page = Page::factory()->createOne();
    $data = [
        'name'          => 'valid name',
        'slug'          => 'valid-slug',
        'more_18'       => false,
        'whatsapp_show' => false,
    ];

    actingAs($user)
        ->put(route('page.update.body', ['id' => '8888']), $data)
        ->assertStatus(Response::HTTP_NOT_FOUND);

    actingAs($user)
        ->put(route('page.update.body', ['id' => $page->id]), $data)
        ->assertStatus(Response::HTTP_NOT_FOUND);
});

test('Deve alterar o body da página', function () {
    $user    = User::factory()->createOne();
    $page    = Page::factory()->createOne(['user_id' => $user->id]);
    $storage = Storage::fake('pages');

    $cloned_page = preg_replace(
        ['/{{ HEAD_TOP }}/', '/{{ HEAD_BOTTOM }}/', '/{{ BODY_TOP }}/', '/{{ COOKIE }}/', '/{{ BODY_BOTTOM }}/'],
        [config('app.head_top'), config('app.head_bottom'), config('app.body_top'),  config('app.cookie'), config('app.body_bottom')],
        file_get_contents(base_path('/tests/html/cloned_and_edited_site.html'))
    );

    $storage->put($page->file . '.html', $cloned_page);

    $body = '';

    if (preg_match('/(<\s*body[^>]*>(?:[\w|\W]*)<\/\s*body[^>]*>)/', $cloned_page, $matches)) {
        $body = trim($matches[1]);
    }

    $newBody = <<<'HTML'
    <body>
        batata
    </body>
    HTML;

    expect($newBody)->not->toBe($body);

    $data = [
        'body' => $newBody,
    ];

    actingAs($user)
        ->from(route('page.edit', ['id' => $page->id]))
        ->followingRedirects()
        ->put(route('page.update.body', ['id' => $page->id]), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Edit')
                ->where('auth.user', $user)
                ->where('errors', [])
                ->where('flash.notification', ['type' => 'success', 'text' => __('app.success.page.updated')])
        );

    $cloned_page = $storage->get($page->file . '.html');

    if (preg_match('/(<\s*body[^>]*>(?:[\w|\W]*)<\/\s*body[^>]*>)/', $cloned_page, $matches)) {
        $body = trim($matches[1]);
    }

    expect($newBody)->toBe($body);

});

