<?php

namespace Database\Factories;

use App\Models\GeneralSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GeneralSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'commission' => $this->faker->randomDigitNotNull,
        'commission_unit' => $this->faker->word,
        'app_name' => $this->faker->word,
        'currency_unit' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
