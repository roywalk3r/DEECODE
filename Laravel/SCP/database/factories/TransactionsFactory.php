<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Payments;
use App\Models\Transactions;

class TransactionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transactions::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'payment_id' => $this->faker->word(),
            'transaction_id' => $this->faker->word(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'transaction_date' => $this->faker->dateTime(),
            'status' => $this->faker->word(),
            'payments_id' => Payments::factory(),
        ];
    }
}
