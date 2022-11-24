<?php

namespace Database\Factories;

use App\Models\FinanceVendorService;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinanceVendorServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinanceVendorService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
        'principal' => $this->faker->randomDigitNotNull,
        'interest_rate' => $this->faker->randomDigitNotNull,
        'interest_rate_unit' => $this->faker->word,
        'duration' => $this->faker->randomDigitNotNull,
        'duration_unit' => $this->faker->word,
        'status' => $this->faker->word,
        'simple_interest' => $this->faker->randomDigitNotNull,
        'total_amount_paid_back' => $this->faker->randomDigitNotNull,
        'vendor_category_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
