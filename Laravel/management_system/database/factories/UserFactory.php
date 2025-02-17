<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'ip_address' => $this->faker->regexify('[A-Za-z0-9]{45}'),
            'username' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'salt' => $this->faker->word(),
            'email' => $this->faker->safeEmail(),
            'activation_code' => $this->faker->regexify('[A-Za-z0-9]{40}'),
            'forgotten_password_code' => $this->faker->regexify('[A-Za-z0-9]{40}'),
            'forgotten_password_time' => $this->faker->randomNumber(),
            'remember_code' => $this->faker->regexify('[A-Za-z0-9]{40}'),
            'created_on' => $this->faker->randomNumber(),
            'last_login' => $this->faker->randomNumber(),
            'active' => $this->faker->randomDigitNotNull(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'company' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
