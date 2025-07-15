<?php
namespace Database\Seeders;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Database\Seeder;

class CompanyJobSeeder extends Seeder
{
    public function run()
    {
        // Create 10 companies
        Company::factory()
            ->count(10)
            // Each company will have 3-8 jobs
            ->has(Job::factory()->count(rand(3, 8)))
            ->create();
        
        // Alternatively, you could do:
        // $companies = Company::factory()->count(10)->create();
        // $companies->each(function ($company) {
        //     Job::factory()->count(rand(3, 8))->create([
        //         'company_id' => $company->id
        //     ]);
        // });
    }
}
