<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\File;
use App\Models\User;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'realpath' => $this->faker->word(),
            'link' => $this->faker->word(),
            'filename' => $this->faker->word(),
            'extension' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'type' => $this->faker->word(),
            'folder' => $this->faker->word(),
            'date_upload' => $this->faker->dateTime(),
            'thumb' => $this->faker->word(),
            'size' => $this->faker->randomFloat(4, 0, 999999999999999999999.9999),
            'user_id' => User::factory(),
            'trash' => $this->faker->boolean(),
        ];
    }
}
