<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyMember>
 */
class FamilyMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'       => fake()->name(),
            'gender' => Arr::random(['ذكر', 'أنثى']),
            'relation' => Arr::random( ['اب', 'ام', 'اخ', 'اخت', 'زوجة', 'ابن', 'ابنة']),
            'phone_number' => fake()->numberBetween(100000000, 9999999999), 
            'age' => fake()->numberBetween(0, 100), 
            'national_number' => fake()->numberBetween(0, 9999999999), 
            'health_insurance_number' => fake()->numberBetween(0, 9999999999), 
            'health_insurance_start_date' => fake()->date, 
            'health_insurance_end_date' => fake()->date, 
            'birth_date' => fake()->date,
            'family_id' => 2
        ];
    }
}
