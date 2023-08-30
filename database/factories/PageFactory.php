<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
final class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'             => fake()->word(),
            'slug'             => fake()->slug(),
            'user_id'          => User::factory(),
            'cloned_from'      => fake()->url(),
            'created_at'       => fake()->dateTimeBetween('-1 weeks'),
            'whatsapp_show'    => fake()->boolean(),
            'whatsapp_number'  => fake()->phoneNumber(),
            'whatsapp_message' => fake()->text(),
        ];
    }
}
