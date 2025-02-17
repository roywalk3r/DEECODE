<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Biller;
use App\Models\Invoice;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'reference' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'date' => $this->faker->date(),
            'date_due' => $this->faker->date(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'status' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'bill_to_id' => Biller::factory(),
            'note' => $this->faker->text(),
            'terms' => $this->faker->text(),
            'currency' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'discount_type' => $this->faker->boolean(),
            'subtotal' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'global_discount' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'shipping' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total_discount' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'total_tax' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'total' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'count' => $this->faker->numberBetween(-10000, 10000),
            'total_due' => $this->faker->randomFloat(2, 0, 99999999.99),
            'payment_date' => $this->faker->date(),
            'estimate_id' => ::factory(),
            'recurring_id' => $this->faker->numberBetween(-10000, 10000),
            'double_currency' => $this->faker->boolean(),
            'rate' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'user_id' => ::factory(),
            'custom_field1' => $this->faker->word(),
            'custom_field2' => $this->faker->word(),
            'custom_field3' => $this->faker->word(),
            'custom_field4' => $this->faker->word(),
        ];
    }
}
