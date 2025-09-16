<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class notificationsFactory extends Factory
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
            'id' => fake()->uuid(),
            'notifiable_id' => '102',
            'notifiable_type' => 'App\Models\UserAccount',
            'type' => 'App\Notifications\LikeNotification',
            'data' => [
                'id' => fake()->numberBetween(6, 198),
                'name' => fake()->name(),
                'post_id' => fake()->numberBetween(1, 227),
                'message' => 'someone like your post'
            ],
            'read_at' => null,
        ];
    }
}
