<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\RecurringInvoice;
use App\Models\RecurringInvoiceItem;

class RecurringInvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecurringInvoiceItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'recurring_id' => $this->faker->numberBetween(-10000, 10000),
            'date' => $this->faker->date(),
            'skip' => $this->faker->boolean(),
            'recurring_invoice_id' => RecurringInvoice::factory(),
        ];
    }
}
