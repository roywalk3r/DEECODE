<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Project;
use App\Models\ProjectTask;

class ProjectTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTask::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'subject' => $this->faker->word(),
            'hour_rate' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'date' => $this->faker->date(),
            'date_due' => $this->faker->date(),
            'priority' => $this->faker->numberBetween(-10000, 10000),
            'description' => $this->faker->text(),
            'attachments' => $this->faker->text(),
            'status' => $this->faker->word(),
            'user_id' => ::factory(),
        ];
    }
}
