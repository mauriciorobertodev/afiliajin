<?php

use App\Actions\Util\GetLinks;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

test('Deve redirecionar para tela de login caso o usuário não esteja logado', function () {
    $page = Page::factory()->createOne();

    put(route('page.update.links', ['id' => $page->id]))
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
        ->put(route('page.update.links', ['id' => '8888']), $data)
        ->assertStatus(Response::HTTP_NOT_FOUND);

    actingAs($user)
        ->put(route('page.update.links', ['id' => $page->id]), $data)
        ->assertStatus(Response::HTTP_NOT_FOUND);
});

test('Deve alterar os links passados', function () {
    $user    = User::factory()->createOne();
    $page    = Page::factory()->createOne(['user_id' => $user->id]);
    $storage = Storage::fake('pages');

    $cloned_page = preg_replace(
        ['/{{ HEAD_TOP }}/', '/{{ HEAD_BOTTOM }}/', '/{{ BODY_TOP }}/', '/{{ COOKIE }}/', '/{{ BODY_BOTTOM }}/'],
        [config('app.head_top'), config('app.head_bottom'), config('app.body_top'),  config('app.cookie'), config('app.body_bottom')],
        file_get_contents(base_path('/tests/html/cloned_and_edited_site.html'))
    );

    $storage->put($page->file . '.html', $cloned_page);

    $links = GetLinks::run($cloned_page);

    expect($links)->toBe([
        'videos'    => [
            'https://www.youtube.com/embed/batata',
        ],
        'images'    => [],
        'checkouts' => [],
        'links'     => [
            'http://batata.com.br',
        ],
    ]);

    $data = [
        'replace' => [
            'https://www.youtube.com/embed/batata' => 'https://www.youtube.com/embed/tomate',
            'http://batata.com.br'                 => 'http://tomate.com.br',
        ],
    ];

    actingAs($user)
        ->from(route('page.edit', ['id' => $page->id]))
        ->followingRedirects()
        ->put(route('page.update.links', ['id' => $page->id]), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Edit')
                ->where('auth.user', $user)
                ->where('errors', [])
                ->where('flash.notification', ['type' => 'success', 'text' => __('app.success.page.updated')])
        );

    $links = GetLinks::run($storage->get($page->file . '.html'));

    expect($links)->toBe([
        'videos'    => [
            'https://www.youtube.com/embed/tomate',
        ],
        'images'    => [],
        'checkouts' => [],
        'links'     => [
            'http://tomate.com.br',
        ],
    ]);

});

