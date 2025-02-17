<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Supplier;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'fullname' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'website' => $this->faker->word(),
            'address' => $this->faker->text(),
            'address2' => $this->faker->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->regexify('[A-Za-z0-9]{55}'),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'company' => $this->faker->company(),
            'vat_number' => $this->faker->word(),
            'user_id' => $this->faker->randomNumber(),
            'custom_field1' => $this->faker->word(),
            'custom_field2' => $this->faker->word(),
            'custom_field3' => $this->faker->word(),
            'custom_field4' => $this->faker->word(),
        ];
    }
}
