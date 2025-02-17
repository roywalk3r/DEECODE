<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Biller;
use App\Models\Project;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'biller_id' => Biller::factory(),
            'progress' => $this->faker->numberBetween(-10000, 10000),
            'billing_type' => $this->faker->word(),
            'rate' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'currency' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'estimated_hours' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->word(),
            'date' => $this->faker->date(),
            'date_due' => $this->faker->date(),
            'members' => $this->faker->text(),
            'description' => $this->faker->text(),
            'user_id' => ::factory(),
        ];
    }
}
