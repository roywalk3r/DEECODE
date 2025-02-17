<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Calendar;

class CalendarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Calendar::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'repeat_type' => $this->faker->numberBetween(-10000, 10000),
            'repeat_days' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'no_end' => $this->faker->boolean(),
            'emails' => $this->faker->word(),
            'subject' => $this->faker->word(),
            'additional_content' => $this->faker->text(),
            'attachments' => $this->faker->text(),
            'last_send' => $this->faker->date(),
        ];
    }
}
