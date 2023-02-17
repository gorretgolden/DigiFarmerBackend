<?php

namespace Database\Factories;

use App\Models\LoanApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
        'finance_vendor_service_id' => $this->faker->randomDigitNotNull,
        'location' => $this->faker->word,
        'location_details' => $this->faker->word,
        'status' => $this->faker->word,
        'loan_number' => $this->faker->word,
        'finance_vendor_category_id' => $this->faker->randomDigitNotNull,
        'gender' => $this->faker->word,
        'dob' => $this->faker->word,
        'age' => $this->faker->randomDigitNotNull,
        'nok_name' => $this->faker->word,
        'nok_email' => $this->faker->word,
        'nok_phone' => $this->faker->word,
        'nok_location' => $this->faker->word,
        'nok_relationship' => $this->faker->word,
        'employment_status' => $this->faker->word,
        'loan_start_date' => $this->faker->word,
        'loan_due_date' => $this->faker->word,
        'document' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
