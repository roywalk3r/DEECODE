<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Invoice;
use App\Models\Receipt;

class ReceiptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Receipt::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'biller_id' => ::factory(),
            'number' => $this->faker->numberBetween(-10000, 10000),
            'date' => $this->faker->date(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'method' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'details' => $this->faker->text(),
            'credit_card' => $this->faker->text(),
            'token' => $this->faker->word(),
        ];
    }
}
