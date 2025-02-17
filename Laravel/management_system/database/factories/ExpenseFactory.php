<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Expense;
use App\Models\User;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->numberBetween(-10000, 10000),
            'reference' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'category' => $this->faker->word(),
            'date' => $this->faker->date(),
            'date_due' => $this->faker->date(),
            'status' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'amount' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'tax_id' => $this->faker->numberBetween(-10000, 10000),
            'tax_type' => $this->faker->boolean(),
            'tax_value' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'tax_total' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'total' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'total_due' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'payment_method' => $this->faker->word(),
            'payment_date' => $this->faker->date(),
            'details' => $this->faker->text(),
            'attachments' => $this->faker->text(),
            'supplier_id' => ::factory(),
            'currency' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'user_id' => User::factory(),
            'approval_status' => $this->faker->randomElement(["denied","approved","waiting"]),
        ];
    }
}
