<?php

namespace Database\Factories;

use App\Models\Martyr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\family>
 */
class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category' => $this->faker->randomElement(['أرملة و ابناء','أب و أم و أخوان و أخوات','أخوات','مكتفية']), 'family_size'=> $this->faker->randomDigitNotZero(), 
            'supervisor_id' => null, 
            'martyr_id' => $this->faker->randomElement(Martyr::pluck('id'))
        ];
    }
}
