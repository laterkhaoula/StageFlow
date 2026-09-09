<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'message' => fake()->sentence(),
            'type' => fake()->randomElement([
                'info',
                'success',
                'warning',
            ]),
            'date_notification' => fake()->date(),
            'lue' => fake()->boolean(),
        ];
    }
}