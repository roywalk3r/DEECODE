<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Biller;
use App\Models\User;

class BillerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Biller::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'fullname' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'dob' => $this->faker->date(),
            'kyc' => $this->faker->word(),
            'website' => $this->faker->word(),
            'address' => $this->faker->text(),
            'address2' => $this->faker->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->regexify('[A-Za-z0-9]{55}'),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'company' => $this->faker->company(),
            'vat_number' => $this->faker->word(),
            'user_id' => User::factory(),
            'custom_field1' => $this->faker->word(),
            'custom_field2' => $this->faker->word(),
            'custom_field3' => $this->faker->word(),
            'custom_field4' => $this->faker->word(),
            'student_name' => $this->faker->word(),
            'school_name' => $this->faker->word(),
            'school_location' => $this->faker->word(),
            'hall' => $this->faker->word(),
            'guardian' => $this->faker->word(),
            'school_year' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'dob_student' => $this->faker->date(),
        ];
    }
}
