<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MartyrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'                   => fake()->name(),
            'rank'                   => Arr::random(['جندي', 'جندي أول', 'عريف', 'وكيل عريف', 'رقيب', 'رقيب أول', 'مساعد', 'مساعد أول', 'ملازم', 'ملازم أول', 'نقيب', 'رائد', 'مقدم', 'عقيد', 'عميد', 'لواء', 'فريق', 'فريق أول', 'مشير']),
            'force' => Arr::random(['جهاز الأمن', 'شرطة موحدة', 'قوات مسلحة', 'قرارات', 'شهداء الكرامة']),
            'unit' =>  Arr::random(['مخابرات', 'الخاصة', 'الصاعقة']),
            'record_date' => fake()->date, 
            'record_number' => fake()->numberBetween(100000000, 2147483647), 
            'martyrdom_date' => fake()->date, 
            'martyrdom_place' => fake()->city, 
            'marital_status' => Arr::random(['أعزب', 'متزوج', 'مطلق', 'منفصل']),
            'militarism_number' => fake()->numberBetween(100000000, 2147483647),
            'rights' => fake()->numberBetween(0, 100000000)
        ];
    }
}
