<?php

namespace Database\Factories;

use App\Models\Plot;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'size' => $this->faker->randomDigitNotNull,
        'size_unit' => $this->faker->word,
        'farm_id' => $this->faker->randomDigitNotNull,
        'crop_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
