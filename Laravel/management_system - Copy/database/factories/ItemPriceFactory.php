<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\ItemPrice;

class ItemPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ItemPrice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'price' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'currency' => $this->faker->regexify('[A-Za-z0-9]{10}'),
        ];
    }
}
