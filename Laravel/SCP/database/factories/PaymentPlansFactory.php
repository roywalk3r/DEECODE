<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Invoices;
use App\Models\PaymentPlans;

class PaymentPlansFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentPlans::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_id' => $this->faker->word(),
            'number_of_installments' => $this->faker->numberBetween(-10000, 10000),
            'installment_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'frequency' => $this->faker->word(),
            'start_date' => $this->faker->date(),
            'invoices_id' => Invoices::factory(),
        ];
    }
}
