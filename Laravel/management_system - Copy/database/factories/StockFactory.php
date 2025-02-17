<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\Stock;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'name' => $this->faker->name(),
            'category' => $this->faker->word(),
            'price' => $this->faker->numberBetween(-10000, 10000),
            'total_price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'last_updated' => $this->faker->dateTime(),
        ];
    }
}
