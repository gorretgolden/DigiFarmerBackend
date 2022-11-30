<?php

namespace Database\Factories;

use App\Models\AnimalFeedSubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalFeedSubCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnimalFeedSubCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'animal_feed_sub_category_id' => $this->faker->randomDigitNotNull,
        'price' => $this->faker->randomDigitNotNull,
        'price_unit' => $this->faker->word,
        'description' => $this->faker->text,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
