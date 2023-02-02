<?php

namespace Database\Factories;

use App\Models\RentVendorService;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentVendorServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RentVendorService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'rent_vendor_sub_category_id' => $this->faker->randomDigitNotNull,
        'charge' => $this->faker->randomDigitNotNull,
        'charge_unit' => $this->faker->word,
        'total_charge' => $this->faker->randomDigitNotNull,
        'description' => $this->faker->text,
        'location' => $this->faker->word,
        'quantity' => $this->faker->randomDigitNotNull,
        'charge_day' => $this->faker->randomDigitNotNull,
        'charge_frequency' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull,
        'vendor_category_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
