<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Log;
use App\Models\User;

class LogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Log::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTime(),
            'user_id' => User::factory(),
            'username' => $this->faker->userName(),
            'controller' => $this->faker->word(),
            'method' => $this->faker->word(),
            'param' => $this->faker->word(),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
