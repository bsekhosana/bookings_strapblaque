<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'        => fake()->firstName,
            'last_name'         => fake()->lastName,
            'email'             => fake()->unique()->safeEmail,
            'avatar'            => '/images/placeholders/avatar.png',
            'email_verified_at' => now(),
            'password'          => '$2y$12$tX5sznSNwH9GHEPNV0w.Se07aoqiQv47WGQE0lN.gnUwvqLfe91aq', // password
            'api_token'         => \Str::random(40),
            'remember_token'    => \Str::random(60),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
