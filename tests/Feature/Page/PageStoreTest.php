<?php

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\get;

test('Deve redirecionar para tela de login caso o usuário não esteja logado', function () {
    get(route('page.store'))
        ->assertRedirectToRoute('login');
});

test('Deve retornar um erro caso os campos (name, slug, cloned_from) não sejam preenchidos', function () {
    $user = User::factory()->createOne();

    actingAs($user)
        ->from(route('page.create'))
        ->followingRedirects()
        ->post(route('page.store'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Create')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.name', __('validation.required', ['attribute' => __('validation.attributes.name')]))
                ->where('errors.slug', __('validation.required', ['attribute' => __('validation.attributes.slug')]))
                ->where('errors.cloned_from', __('validation.required', ['attribute' => __('validation.attributes.cloned_from')]))
        );
});

test('Deve retornar um erro caso os campos (name, slug) tenham menos de 3 caracteres', function () {
    $user = User::factory()->createOne();
    $data = [
        'name' => 'a',
        'slug' => 'b',
    ];

    actingAs($user)
        ->from(route('page.create'))
        ->followingRedirects()
        ->post(route('page.store'), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Create')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.name', __('validation.min.string', ['min' => '3', 'attribute' => __('validation.attributes.name')]))
                ->where('errors.slug', __('validation.min.string', ['min' => '3', 'attribute' => __('validation.attributes.slug')]))
        );
});

test('Deve retornar um erro caso os campos (name, slug) tenham mais de 255 caracteres', function () {
    $user = User::factory()->createOne();
    $data = [
        'name' => str_repeat('a', 256),
        'slug' => str_repeat('a', 256),
    ];

    actingAs($user)
        ->from(route('page.create'))
        ->followingRedirects()
        ->post(route('page.store'), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Create')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.name', __('validation.max.string', ['max' => '255', 'attribute' => __('validation.attributes.name')]))
                ->where('errors.slug', __('validation.max.string', ['max' => '255', 'attribute' => __('validation.attributes.slug')]))
        );
});

test('Deve retornar um erro caso os campos (cloned_from) não sejam urls válidas', function () {
    $user = User::factory()->createOne();
    $data = [
        'cloned_from' => 'invalid_url',
    ];

    actingAs($user)
        ->from(route('page.create'))
        ->followingRedirects()
        ->post(route('page.store'), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Create')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.cloned_from', __('validation.active_url', ['attribute' => __('validation.attributes.cloned_from')]))
        );
});

test('Deve retornar um erro caso não seja possível clonar a página que o usuário passou', function () {

    $user = User::factory()->createOne();
    $data = [
        'cloned_from'   => 'https://test.com/test?batata=tomate',
        'name'          => 'valid_name',
        'slug'          => 'valid-slug',
    ];

    Http::shouldReceive('get')->once()->with('test.com/test/')->andThrowExceptions([new ConnectionException()]);

    actingAs($user)
        ->from(route('page.create'))
        ->followingRedirects()
        ->post(route('page.store'), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Create')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.cloned_from', __('app.errors.clone_fail'))
        );
});

test('Deve retornar um uma mensagem de erro caso não seja possível salvar a página no storage', function () {
    Http::fake(['*' => Http::response('OK')]);

    $user = User::factory()->createOne();
    $data = [
        'cloned_from'   => 'https://test.com',
        'name'          => 'valid_name',
        'slug'          => 'valid-slug',
    ];

    assertDatabaseCount('pages', 0);
    Storage::shouldReceive('disk')->once()->with('pages')->andReturnSelf();
    Storage::shouldReceive('put')->once()->andReturnFalse();

    actingAs($user)
        ->from(route('page.create'))
        ->followingRedirects()
        ->post(route('page.store'), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Create')
                ->where('auth.user', $user)
                ->where('flash.notification', ['type' => 'error', 'text' => __('app.errors.clone_storage_fail')])
                ->has('errors')
                ->where('errors', [])
        );

    assertDatabaseCount('pages', 0);
});

test('Deve salvar a página clonada no storage e redirecionar o usuário para listagem com mensagem de sucesso', function () {
    $storage = Storage::fake('pages');
    Http::fake(['*' => Http::response('OK')]);

    $user = User::factory()->createOne();
    $data = [
        'cloned_from'      => 'https://test.com',
        'name'             => 'valid_name',
        'slug'             => 'valid-slug',
    ];

    // expect($storage->exists($page->file . '.html'))->toBe(false);
    assertDatabaseCount('pages', 0);

    actingAs($user)
        ->from(route('page.create'))
        ->followingRedirects()
        ->post(route('page.store'), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Index')
                ->where('auth.user', $user)
                ->where('flash.notification', ['type' => 'success', 'text' => __('app.success.page.cloned')])
                ->has('errors')
                ->where('errors', [])
        );

    assertDatabaseCount('pages', 1);

    $page = Page::query()->first();

    expect( $storage->exists($page->file . '.html'))->toBe(true);

    expect($page->cloned_from)->toBe('test.com/');
    expect($page->name)->toBe($data['name']);
    expect($page->slug)->toBe($data['slug']);
});
