<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
        $user = User::whereHas('role', fn($q) => $q->where('name', 'company'))->inRandomOrder()->first();

        return [
            'user_id' => $user ? $user->id : 1,
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'description' => $this->faker->sentence,
            'logo' => 'company_logos/logo_' . rand(1,10) . '.png',
            'is_verified' => true,
        ];
    }
}
