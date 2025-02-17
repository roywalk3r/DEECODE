<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Biller;
use App\Models\Contract;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->word(),
            'biller_id' => Biller::factory(),
            'date' => $this->faker->date(),
            'date_due' => $this->faker->date(),
            'type' => $this->faker->word(),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'currency' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'description' => $this->faker->text(),
            'reference' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'count' => $this->faker->numberBetween(-10000, 10000),
            'attachments' => $this->faker->text(),
            'user_id' => ::factory(),
        ];
    }
}
