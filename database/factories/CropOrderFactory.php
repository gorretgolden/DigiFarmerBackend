<?php

namespace Database\Factories;

use App\Models\CropOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CropOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'buying_price' => $this->faker->randomDigitNotNull,
        'has_brought' => $this->faker->word,
        'is_accepted' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
