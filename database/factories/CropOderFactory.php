<?php

namespace Database\Factories;

use App\Models\CropOder;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropOderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CropOder::class;

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
