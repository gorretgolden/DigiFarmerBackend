<?php

namespace Database\Factories;

use App\Models\CropHarvest;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropHarvestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CropHarvest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->randomDigitNotNull,
        'quantity_unit' => $this->faker->word,
        'plot_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
