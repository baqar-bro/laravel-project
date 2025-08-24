<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserAccountFactory extends Factory
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
            'name' => fake()->unique()->name(),
            'about' => fake()->text(100),
            'user_id' => fake()->numberBetween(13 , 110)
        ];
    }
}
