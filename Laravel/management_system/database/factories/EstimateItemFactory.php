<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Estimate;
use App\Models\EstimateItem;
use App\Models\Item;

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
            'item_id' => Item::factory(),
        ];
    }
}
