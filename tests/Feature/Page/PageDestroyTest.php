<?php

use App\Models\Page;
use App\Models\User;
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
    $storage = Storage::fake('pages');
    $user    = User::factory()->createOne();
    $page    = Page::factory()->createOne(['user_id' => $user->id]);
    $storage->put($page->file . '.html', '');

    assertDatabaseCount('pages', 1);
    expect($storage->exists($page->file . '.html'))->toBe(true);

    actingAs($user)
        ->delete(route('page.destroy', ['id' => $page->id]))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('notification', ['type' => 'success', 'text' => __('app.success.page.destroyed')]);

    assertDatabaseCount('pages', 0);
    expect($storage->exists($page->file . '.html'))->toBe(false);
});
