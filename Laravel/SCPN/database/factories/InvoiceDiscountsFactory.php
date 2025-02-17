<?php

namespace Database\Factories;

use App\Models\Discounts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Discount;
use App\Models\InvoiceDiscounts;
use App\Models\Invoices;

class InvoiceDiscountsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceDiscounts::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_id' => $this->faker->word(),
            'discount_id' => Discounts::factory(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'invoices_id' => Invoices::factory(),
        ];
    }
}
