<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ChatMessage;
use App\Models\User;

class ChatMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChatMessage::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraphs(3, true),
            'from' => $this->faker->randomNumber(),
            'to' => $this->faker->randomNumber(),
            'read' => $this->faker->numberBetween(-10000, 10000),
            'date' => $this->faker->dateTime(),
            'date_read' => $this->faker->dateTime(),
            'offline' => $this->faker->numberBetween(-10000, 10000),
            'user_id' => User::factory(),
            'from_id' => User::factory(),
            'to_id' => User::factory(),
        ];
    }
}
