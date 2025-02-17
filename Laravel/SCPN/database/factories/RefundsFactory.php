<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Payments;
use App\Models\Refunds;

class RefundsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Refunds::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'payment_id' => $this->faker->word(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'reason' => $this->faker->word(),
            'status' => $this->faker->word(),
            'refund_date' => $this->faker->dateTime(),
            'payments_id' => Payments::factory(),
        ];
    }
}
