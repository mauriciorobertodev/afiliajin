<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('Deve redirecionar para tela de login caso o usuário não esteja logado', function () {
    get(route('page.create'))
        ->assertRedirectToRoute('login');
});

test('Deve exibir a tela caso o usuário esteja logado', function () {
    $user = User::factory()->createOne();

    actingAs($user)
        ->get(route('page.create'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Page/Create')
            ->where('auth.user', $user));
});
