<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Todo;
use App\Models\User;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->word(),
            'priority' => $this->faker->numberBetween(-10000, 10000),
            'complete' => $this->faker->numberBetween(-10000, 10000),
            'description' => $this->faker->text(),
            'date' => $this->faker->date(),
            'date_due' => $this->faker->date(),
            'user_id' => User::factory(),
            'attachments' => $this->faker->text(),
        ];
    }
}
