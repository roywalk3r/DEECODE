<?php

namespace Database\Factories;

use App\Models\PaymentMethods;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Invoices;
use App\Models\PaymentMethod;
use App\Models\Payments;

class PaymentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payments::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_id' => $this->faker->word(),
            'payment_method_id' => PaymentMethods::factory(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'payment_date' => $this->faker->dateTime(),
            'status' => $this->faker->word(),
            'invoices_id' => Invoices::factory(),
        ];
    }
}
