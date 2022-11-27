<?php

namespace Database\Factories;

use App\Models\CropOnSale;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropOnSaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CropOnSale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->randomDigitNotNull,
        'selling_price' => $this->faker->randomDigitNotNull,
        'quantity_unit' => $this->faker->word,
        'price_unit' => $this->faker->word,
        'is_sold' => $this->faker->word,
        'crop_id' => $this->faker->randomDigitNotNull,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
