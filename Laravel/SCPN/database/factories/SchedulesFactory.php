<?php

namespace Database\Factories;

use App\Models\ClassGroups;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ClassGroup;
use App\Models\Schedules;

class SchedulesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedules::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'class_group_id' => ClassGroups::factory(),
            'day_of_week' => $this->faker->numberBetween(-10000, 10000),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
        ];
    }
}
