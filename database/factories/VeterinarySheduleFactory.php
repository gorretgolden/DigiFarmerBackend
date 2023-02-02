<?php

namespace Database\Factories;

use App\Models\VeterinaryShedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class VeterinarySheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VeterinaryShedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'starting_time' => $this->faker->word,
        'ending_time' => $this->faker->word,
        'day_id' => $this->faker->randomDigitNotNull,
        'veterinary_id' => $this->faker->randomDigitNotNull,
        'time_interval' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
