<?php

namespace Database\Factories;

use App\Models\CropBuyerCropOnSale;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropBuyerCropOnSaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CropBuyerCropOnSale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'crop_on_sale_id' => $this->faker->randomDigitNotNull,
        'crop_buyer_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
