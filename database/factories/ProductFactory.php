<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(100,1000),
            'image' => $this->faker->imageUrl(640,480),
        ];
    }
}
