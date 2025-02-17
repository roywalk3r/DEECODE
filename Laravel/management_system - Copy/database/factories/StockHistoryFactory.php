<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\StockHistory;

class StockHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StockHistory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'previous_quantity' => $this->faker->numberBetween(-10000, 10000),
            'new_quantity' => $this->faker->numberBetween(-10000, 10000),
            'updated_at' => $this->faker->dateTime(),
            'updated_by' => $this->faker->word(),
        ];
    }
}
