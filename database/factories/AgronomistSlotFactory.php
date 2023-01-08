<?php

namespace Database\Factories;

use App\Models\AgronomistSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgronomistSlotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgronomistSlot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'agronomist_shedule_id' => $this->faker->randomDigitNotNull,
        'start_time' => $this->faker->word,
        'end_time' => $this->faker->word,
        'status' => $this->faker->randomElement(['Taken']),
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
