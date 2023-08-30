<?php

use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\delete;

test('Deve redirecionar para tela de login caso o usuário não esteja logado', function () {
    $page = Page::factory()->createOne();

    delete(route('page.destroy', ['id' => $page->id]))
        ->assertRedirectToRoute('login');
});

test('Deve excluir uma página quanto no banco como no storage', function () {
    $user = User::factory()->createOne();

    $storage = Storage::fake('pages');
    Http::fake(['*' => Http::response('OK')]);

    expect($storage->exists('valid-slug.blade.php'))->toBe(false);
    assertDatabaseCount('pages', 0);

    $data = [
        'cloned_from'   => 'https://test.com',
        'name'          => 'valid_name',
        'slug'          => 'valid-slug',
        'whatsapp_show' => false,
    ];

    actingAs($user)
        ->post(route('page.store'), $data);

    expect($storage->exists('valid-slug.blade.php'))->toBe(true);
    assertDatabaseCount('pages', 1);

    $page = Page::query()->first();

    actingAs($user)
        ->delete(route('page.destroy', ['id' => $page->id]))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('notification', ['type' => 'success', 'text' => __('app.success.page.destroyed')]);
});
