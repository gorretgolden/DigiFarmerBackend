<?php

namespace Database\Factories;

use App\Models\FarmerTraining;
use Illuminate\Database\Eloquent\Factories\Factory;

class FarmerTrainingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FarmerTraining::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
        'training_vendor_service_id' => $this->faker->randomDigitNotNull,
        'starting_date' => $this->faker->word,
        'ending_date' => $this->faker->word,
        'access' => $this->faker->word,
        'period' => $this->faker->randomDigitNotNull,
        'period_unit' => $this->faker->word,
        'farmer_time' => $this->faker->word,
        'status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
