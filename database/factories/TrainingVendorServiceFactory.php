<?php

namespace Database\Factories;

use App\Models\TrainingVendorService;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingVendorServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrainingVendorService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'charge' => $this->faker->randomDigitNotNull,
        'description' => $this->faker->text,
        'image' => $this->faker->word,
        'access' => $this->faker->word,
        'is_verified' => $this->faker->word,
        'starting_date' => $this->faker->word,
        'ending_date' => $this->faker->word,
        'starting_time' => $this->faker->word,
        'ending_time' => $this->faker->word,
        'zoom_details' => $this->faker->text,
        'location' => $this->faker->word,
        'vendor_category_id' => $this->faker->randomDigitNotNull,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
