<?php

namespace Database\Factories;

use App\Models\SellerProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class SellerProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SellerProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'image' => $this->faker->word,
        'price' => $this->faker->randomDigitNotNull,
        'stock_amount' => $this->faker->randomDigitNotNull,
        'is_verified' => $this->faker->word,
        'status' => $this->faker->word,
        'price_unit' => $this->faker->word,
        'description' => $this->faker->text,
        'seller_product_category_id' => $this->faker->randomDigitNotNull,
        'vendor_category_id' => $this->faker->randomDigitNotNull,
        'location' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
