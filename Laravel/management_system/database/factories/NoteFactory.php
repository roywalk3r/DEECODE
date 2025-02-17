<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Note;
use App\Models\User;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'body' => $this->faker->text(),
            'priority' => $this->faker->randomElement(["high","medium","low"]),
            'status' => $this->faker->randomElement(["start","pending","completed"]),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
