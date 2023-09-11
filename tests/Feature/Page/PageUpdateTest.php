<?php

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Response;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('Deve redirecionar para tela de login caso o usuário não esteja logado', function () {
    $page = Page::factory()->createOne();

    get(route('page.update', ['id' => $page->id]))
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
        ->put(route('page.update', ['id' => '8888']), $data)
        ->assertStatus(Response::HTTP_NOT_FOUND);

    actingAs($user)
        ->put(route('page.update', ['id' => $page->id]), $data)
        ->assertStatus(Response::HTTP_NOT_FOUND);
});

test('Deve retornar um erro caso os campos (name, slug, whatsapp_show, more_18) não sejam preenchidos', function () {
    $user = User::factory()->createOne();
    $page = Page::factory()->createOne(['user_id' => $user->id]);

    actingAs($user)
        ->from(route('page.edit', ['id' => $page->id]))
        ->followingRedirects()
        ->put(route('page.update', ['id' => $page->id]))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Edit')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.name', __('validation.required', ['attribute' => __('validation.attributes.name')]))
                ->where('errors.slug', __('validation.required', ['attribute' => __('validation.attributes.slug')]))
                ->where('errors.whatsapp_show', __('validation.required', ['attribute' => __('validation.attributes.whatsapp_show')]))
                ->where('errors.more_18', __('validation.required', ['attribute' => __('validation.attributes.more_18')]))
        );
});

test('Deve retornar um erro caso os campos (name, slug, whatsapp_number, whatsapp_message) tenham menos caracteres do que o limite', function () {
    $user = User::factory()->createOne();
    $page = Page::factory()->createOne(['user_id' => $user->id]);
    $data = [
        'name'             => 'a',
        'slug'             => 'b',
        'whatsapp_number'  => 'a',
        'whatsapp_message' => 'a',
    ];

    actingAs($user)
        ->from(route('page.edit', ['id' => $page->id]))
        ->followingRedirects()
        ->put(route('page.update', ['id' => $page->id]), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Edit')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.name', __('validation.min.string', ['min' => '3', 'attribute' => __('validation.attributes.name')]))
                ->where('errors.slug', __('validation.min.string', ['min' => '3', 'attribute' => __('validation.attributes.slug')]))
                ->where('errors.whatsapp_number', __('validation.min.string', ['min' => '12', 'attribute' => __('validation.attributes.whatsapp_number')]))
                ->where('errors.whatsapp_message', __('validation.min.string', ['min' => '3', 'attribute' => __('validation.attributes.whatsapp_message')]))
        );
});

test('Deve retornar um erro caso os campos (name, slug, whatsapp_number) tenham mais caracteres do que o limite', function () {
    $user = User::factory()->createOne();
    $page = Page::factory()->createOne(['user_id' => $user->id]);
    $data = [
        'name'             => str_repeat('a', 256),
        'slug'             => str_repeat('a', 256),
        'whatsapp_number'  => str_repeat('5', 14),
    ];

    actingAs($user)
        ->from(route('page.edit', ['id' => $page->id]))
        ->followingRedirects()
        ->put(route('page.update', ['id' => $page->id]), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Edit')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.name', __('validation.max.string', ['max' => '255', 'attribute' => __('validation.attributes.name')]))
                ->where('errors.slug', __('validation.max.string', ['max' => '255', 'attribute' => __('validation.attributes.slug')]))
                ->where('errors.whatsapp_number', __('validation.max.string', ['max' => '13', 'attribute' => __('validation.attributes.whatsapp_number')]))
        );
});

test('Deve retornar um erro caso o campo (whatsapp_show) for verdadeiro então o campo (whatsapp_number) é requirido', function () {
    $user = User::factory()->createOne();
    $page = Page::factory()->createOne(['user_id' => $user->id]);
    $data = [
        'whatsapp_show'    => true,
    ];

    actingAs($user)
        ->from(route('page.edit', ['id' => $page->id]))
        ->followingRedirects()
        ->put(route('page.update', ['id' => $page->id]), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Edit')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors.whatsapp_number', __('app.validations.whatsapp_number_required_if'))
        );
});

test('Deve atualizar os dados de uma página', function () {
    $user = User::factory()->createOne();
    $page = Page::factory()->createOne(['user_id' => $user->id, 'more_18' => true, 'whatsapp_show' => false]);
    $data = [
        'name'             => 'Valid Name',
        'slug'             => 'valid-slug',
        'more_18'          => false,
        'whatsapp_show'    => true,
        'whatsapp_number'  => '5514334254367',
        'whatsapp_message' => 'Olá, gostaria de saber mais sobre o produto.',
        'cookie'           => 'https://go.hotmart.com/H78789789',
        'head_top'         => 'head top',
        'head_bottom'      => 'head bottom',
        'body_top'         => 'body top',
        'body_bottom'      => 'body bottom',
    ];

    expect($page->name)->not->toBe($data['name']);
    expect($page->slug)->not->toBe($data['slug']);
    expect($page->more_18)->not->toBe($data['more_18']);
    expect($page->whatsapp_show)->not->toBe($data['whatsapp_show']);
    expect($page->whatsapp_number)->not->toBe($data['whatsapp_number']);
    expect($page->whatsapp_message)->not->toBe($data['whatsapp_message']);
    expect($page->cookie)->not->toBe($data['cookie']);
    expect($page->head_top)->not->toBe($data['head_top']);
    expect($page->head_bottom)->not->toBe($data['head_bottom']);
    expect($page->body_top)->not->toBe($data['body_top']);
    expect($page->body_bottom)->not->toBe($data['body_bottom']);

    actingAs($user)
        ->from(route('page.edit', ['id' => $page->id]))
        ->followingRedirects()
        ->put(route('page.update', ['id' => $page->id]), $data)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Page/Edit')
                ->where('auth.user', $user)
                ->has('errors')
                ->where('errors', [])
                ->where('flash.notification', ['type' => 'success', 'text' => __('app.success.page.updated')])
        );

    $page->refresh();

    expect($page->name)->toBe($data['name']);
    expect($page->slug)->toBe($data['slug']);
    expect($page->more_18)->toBe($data['more_18']);
    expect($page->whatsapp_show)->toBe($data['whatsapp_show']);
    expect($page->whatsapp_number)->toBe($data['whatsapp_number']);
    expect($page->whatsapp_message)->toBe($data['whatsapp_message']);
    expect($page->cookie)->toBe($data['cookie']);
    expect($page->head_top)->toBe($data['head_top']);
    expect($page->head_bottom)->toBe($data['head_bottom']);
    expect($page->body_top)->toBe($data['body_top']);
    expect($page->body_bottom)->toBe($data['body_bottom']);
});
