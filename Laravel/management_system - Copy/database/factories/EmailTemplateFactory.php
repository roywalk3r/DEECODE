<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EmailTemplate;

class EmailTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailTemplate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'language' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'subject' => $this->faker->word(),
            'content' => $this->faker->paragraphs(3, true),
            'data' => $this->faker->word(),
        ];
    }
}
