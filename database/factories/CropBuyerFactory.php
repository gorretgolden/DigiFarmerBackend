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
        'has_bought' => $this->faker->word,
        'contact_one' => $this->faker->word,
        'contact_two' => $this->faker->word,
        'email' => $this->faker->word,
        'is_accepted' => $this->faker->word,
        'crop_on_sale_id' => $this->faker->randomDigitNotNull,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
