<?php

namespace Database\Factories;

use App\Models\FarmerBuySellerProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class FarmerBuySellerProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FarmerBuySellerProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_product_bought' => $this->faker->word,
        'seller_product_id' => $this->faker->randomDigitNotNull,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
