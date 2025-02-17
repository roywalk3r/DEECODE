<?php

namespace Database\Factories;

use App\Models\ClassGroups;
use App\Models\Students;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Attendances;
use App\Models\ClassGroup;
use App\Models\Student;

class AttendancesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendances::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'student_id' => Students::factory(),
            'class_group_id' => ClassGroups::factory(),
            'date' => $this->faker->date(),
            'status' => $this->faker->word(),
        ];
    }
}
