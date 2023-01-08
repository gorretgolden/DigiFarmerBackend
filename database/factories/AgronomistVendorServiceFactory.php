<?php

namespace Database\Factories;

use App\Models\AgronomistVendorService;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgronomistVendorServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgronomistVendorService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'expertise' => $this->faker->text,
        'charge' => $this->faker->randomDigitNotNull,
        'charge_unit' => $this->faker->word,
        'availability' => $this->faker->word,
        'description' => $this->faker->text,
        'zoom_details' => $this->faker->text,
        'location_details' => $this->faker->text,
        'image' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull,
        'vendor_category_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
