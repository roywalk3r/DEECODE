<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TaxRate;

class TaxRateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxRate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'value' => $this->faker->randomFloat(2, 0, 99999999.99),
            'type' => $this->faker->boolean(),
            'is_default' => $this->faker->boolean(),
            'can_delete' => $this->faker->boolean(),
        ];
    }
}
