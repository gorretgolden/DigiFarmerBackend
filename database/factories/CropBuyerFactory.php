<?php

namespace Database\Factories;

use App\Models\CropBuyer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropBuyerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CropBuyer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'buying_price' => $this->faker->randomDigitNotNull,
        'crop_on_sale_id' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->word,
        'is_bought' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
