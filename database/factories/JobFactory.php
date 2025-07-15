<?php
namespace Database\Factories;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(), 
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraphs(3, true),
            'location' => $this->faker->city(),
            'salary_min' => $this->faker->randomFloat(2, 30000, 70000),
            'salary_max' => $this->faker->randomFloat(2, 70000, 150000),
            'position_type' => $this->faker->randomElement(['remote', 'in-person', 'hybrid']),
            'salary_currency' => 'USD',
            'is_published' => $this->faker->boolean(70), // 70% chance of being published
            'published_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'), 
        ];
    }
}