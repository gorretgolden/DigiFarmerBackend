<?php

namespace Database\Factories;

use App\Models\InsuaranceVendorService;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsuaranceVendorServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InsuaranceVendorService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'terms' => $this->faker->text,
        'image' => $this->faker->word,
        'description' => $this->faker->text,
        'is_verified' => $this->faker->word,
        'location' => $this->faker->word,
        'user_id' => $this->faker->randomDigitNotNull,
        'vendor_category_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
