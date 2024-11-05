<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>'テスト',
            'representative'=>'テスト',
            'address'=>'テスト',
            'phone_number'=>'0000000',
            'resption_hours'=>'テスト',
            'URL'=>'テスト',
            'establishment_date'=>'テスト',
            'business'=>'テスト',
            'capital'=>'テスト',
        ];
    }
}
