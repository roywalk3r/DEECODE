<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Notifications;
use App\Models\User;

class NotificationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notifications::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->word(),
            'message' => $this->faker->text(),
            'read_at' => $this->faker->dateTime(),
        ];
    }
}
