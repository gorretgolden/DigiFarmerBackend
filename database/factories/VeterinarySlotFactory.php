<?php

namespace Database\Factories;

use App\Models\VeterinarySlot;
use Illuminate\Database\Eloquent\Factories\Factory;

class VeterinarySlotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VeterinarySlot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'time' => $this->faker->word,
        'status' => $this->faker->randomDigitNotNull,
        'veterinary_shedule_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
