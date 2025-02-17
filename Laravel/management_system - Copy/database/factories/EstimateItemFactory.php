<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Estimate;
use App\Models\EstimateItem;

class EstimateItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EstimateItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'estimate_id' => Estimate::factory(),
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
