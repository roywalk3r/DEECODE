<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\User;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->phoneNumber(),
            'order_details' => $this->faker->text(),
            'qty' => $this->faker->numberBetween(-10000, 10000),
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(["pending","out"]),
            'amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'total_amount' => $this->faker->numberBetween(-10000, 10000),
            'company' => $this->faker->company(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
