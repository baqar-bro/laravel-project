<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comments>
 */
class CommentsFactory extends Factory
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
             'comments' => fake()->text(rand(20 , 60)),
            'post_id' => fake()->numberBetween(1 , 220)
        ];
    }
}
