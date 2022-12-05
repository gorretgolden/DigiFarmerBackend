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
        'description' => $this->faker->text,
        'image' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
