<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Audits;
use App\Models\User;

class AuditsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Audits::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'event' => $this->faker->word(),
            'auditable_type' => $this->faker->word(),
            'auditable_id' => $this->faker->randomNumber(),
            'old_values' => '{}',
            'new_values' => '{}',
            'url' => $this->faker->url(),
            'ip_address' => $this->faker->word(),
            'user_agent' => $this->faker->word(),
        ];
    }
}
