<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Biller;
use App\Models\RecurringInvoice;

class RecurringInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecurringInvoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'date' => $this->faker->date(),
            'next_date' => $this->faker->date(),
            'type' => $this->faker->word(),
            'frequency' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'number' => $this->faker->word(),
            'occurence' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->word(),
            'data' => $this->faker->text(),
            'bill_to_id' => Biller::factory(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'user_id' => ::factory(),
        ];
    }
}
