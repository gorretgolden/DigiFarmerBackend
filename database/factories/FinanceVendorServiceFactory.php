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
            'name' => $this->faker->word,
        'principal' => $this->faker->randomDigitNotNull,
        'interest_rate' => $this->faker->randomDigitNotNull,
        'interest_rate_unit' => $this->faker->word,
        'payment_frequency_pay' => $this->faker->randomDigitNotNull,
        'is_verified' => $this->faker->word,
        'simple_interest' => $this->faker->randomDigitNotNull,
        'total_amount_paid_back' => $this->faker->randomDigitNotNull,
        'vendor_category_id' => $this->faker->randomDigitNotNull,
        'user_id' => $this->faker->randomDigitNotNull,
        'loan_plan_id' => $this->faker->randomDigitNotNull,
        'loan_pay_back_id' => $this->faker->randomDigitNotNull,
        'finance_vendor_category_id' => $this->faker->randomDigitNotNull,
        'location' => $this->faker->word,
        'terms' => $this->faker->text,
        'payment_frequency_pay' => $this->faker->randomDigitNotNull,
        'image' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
