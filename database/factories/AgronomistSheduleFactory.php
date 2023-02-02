<?php

namespace Database\Factories;

use App\Models\AgronomistShedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgronomistSheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgronomistShedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'day_id' => $this->faker->randomDigitNotNull,
        'starting_time' => $this->faker->word,
        'ending_time' => $this->faker->word,
        'time_interval' => $this->faker->randomDigitNotNull,
        'agronomist_vendor_service_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
