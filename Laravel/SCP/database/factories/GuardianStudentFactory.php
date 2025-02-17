<?php

namespace Database\Factories;

use App\Models\Guardians;
use App\Models\Students;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Guardian;
use App\Models\GuardianStudent;
use App\Models\Student;

class GuardianStudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GuardianStudent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'guardian_id' => Guardians::factory(),
            'student_id' => Students::factory(),
            'relationship' => $this->faker->word(),
            'is_primary' => $this->faker->boolean(),
        ];
    }
}
