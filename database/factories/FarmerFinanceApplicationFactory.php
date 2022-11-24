<?php

namespace Database\Factories;

use App\Models\FarmerFinanceApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class FarmerFinanceApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FarmerFinanceApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'finance_vendor_service_id' => $this->faker->randomDigitNotNull,
        'user_id' => $this->faker->randomDigitNotNull,
        'is_approved' => $this->faker->word,
        'national_id' => $this->faker->word,
        'drivin_permit' => $this->faker->word,
        'land_title' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
