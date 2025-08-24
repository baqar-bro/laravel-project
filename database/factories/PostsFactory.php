<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Posts>
 */
class PostsFactory extends Factory
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
            'image' => 'https://picsum.photos/seed/' . $this->faker->uuid . '/660/480',
            'text' => fake()->text(rand(20 , 60)),
            'account_id' => fake()->numberBetween(100 , 198)
        ];
    }
}
