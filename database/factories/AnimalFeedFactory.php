<?php

namespace Database\Factories;

use App\Models\AnimalFeed;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalFeedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnimalFeed::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'price' => $this->faker->randomDigitNotNull,
        'price_unit' => $this->faker->word,
        'weight' => $this->faker->randomDigitNotNull,
        'weight_unit' => $this->faker->word,
        'stock_amount' => $this->faker->word,
        'location' => $this->faker->word,
        'image' => $this->faker->word,
        'description' => $this->faker->text,
        'status' => $this->faker->word,
        'is_verified' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull,
        'animal_feed_category_id' => $this->faker->randomDigitNotNull,
        'vendor_category_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
