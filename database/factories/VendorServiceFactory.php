<?php

namespace Database\Factories;

use App\Models\VendorService;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VendorService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'image' => $this->faker->word,
        'price_unit' => $this->faker->word,
        'price' => $this->faker->randomDigitNotNull,
        'description' => $this->faker->text,
        'weight_unit' => $this->faker->word,
        'stock_amount' => $this->faker->randomDigitNotNull,
        'is_verified' => $this->faker->word,
        'expertise' => $this->faker->text,
        'charge' => $this->faker->randomDigitNotNull,
        'charge_frequency' => $this->faker->word,
        'zoom_details' => $this->faker->text,
        'location' => $this->faker->word,
        'starting_date' => $this->faker->word,
        'ending_date' => $this->faker->word,
        'starting_time' => $this->faker->word,
        'ending_time' => $this->faker->word,
        'principal' => $this->faker->randomDigitNotNull,
        'interest_rate' => $this->faker->word,
        'interest_rate_unit' => $this->faker->word,
        'payment_frequency_pay' => $this->faker->randomDigitNotNull,
        'simple_interest' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->word,
        'total_amount_paid_back' => $this->faker->randomDigitNotNull,
        'document_type' => $this->faker->word,
        'terms' => $this->faker->text,
        'loan_pay_back' => $this->faker->word,
        'access' => $this->faker->word,
        'loan_plan_id' => $this->faker->randomDigitNotNull,
        'sub_category_id' => $this->faker->randomDigitNotNull,
        'user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
