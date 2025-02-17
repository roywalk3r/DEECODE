<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\Payment;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'number' => $this->faker->numberBetween(-10000, 10000),
            'date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'method' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'details' => $this->faker->text(),
            'credit_card' => $this->faker->text(),
            'token' => $this->faker->word(),
            'status' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
