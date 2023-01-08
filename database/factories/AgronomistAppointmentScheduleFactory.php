<?php

namespace Database\Factories;

use App\Models\AgronomistAppointmentSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgronomistAppointmentScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgronomistAppointmentSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'day_id' => $this->faker->randomDigitNotNull,
        'agronomist_vendor_service_id' => $this->faker->randomDigitNotNull,
        'start_time' => $this->faker->word,
        'end_time' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
