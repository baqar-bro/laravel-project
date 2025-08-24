<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\likes>
 */
class likesFactory extends Factory
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
            'account_id' => fake()->numberBetween(6 , 198),
            'post_id' => fake()->numberBetween(1 , 220)
            
        ];
    }
}
