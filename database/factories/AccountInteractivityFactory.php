<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountInteractivity>
 */
class AccountInteractivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'followers' => fake()->numberBetween(6 , 102),
            'followings' => fake()->numberBetween(6 , 102)
        ];
    }
}
