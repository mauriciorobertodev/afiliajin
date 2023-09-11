<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $testUser = \App\Models\User::factory()->create([
            'name'     => 'Test User',
            'email'    => 'test@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123'),
        ]);

        \App\Models\Page::factory()->createOne(['user_id' => $testUser->id, 'slug' => 'test']);
        \App\Models\Page::factory(10)->create(['user_id' => $testUser->id]);
    }
}
