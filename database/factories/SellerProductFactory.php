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
        'description' => $this->faker->text,
        'price' => $this->faker->randomDigitNotNull,
        'seller_product_category_id' => $this->faker->randomDigitNotNull,
        'image' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
