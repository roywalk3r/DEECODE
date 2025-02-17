<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LoginAttempt;

class LoginAttemptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoginAttempt::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'ip_address' => $this->faker->regexify('[A-Za-z0-9]{15}'),
            'login' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'time' => $this->faker->randomNumber(),
        ];
    }
}
