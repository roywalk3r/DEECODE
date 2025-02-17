<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'item_id' => ::factory(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'quantity' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'unit_price' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'tax_type' => $this->faker->boolean(),
            'tax' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'discount_type' => $this->faker->boolean(),
            'discount' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'total' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
        ];
    }
}
