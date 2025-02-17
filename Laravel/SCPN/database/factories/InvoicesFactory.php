<?php

namespace Database\Factories;

use App\Models\FeeStructures;
use App\Models\Students;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\FeeStructure;
use App\Models\Invoices;
use App\Models\Student;

class InvoicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoices::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'student_id' => Students::factory(),
            'fee_structure_id' => FeeStructures::factory(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'due_date' => $this->faker->date(),
            'status' => $this->faker->word(),
        ];
    }
}
