<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'companies' => Company::withCount('jobs')
                            ->latest()
                            ->paginate(5),
            'recentJobs' => Job::with('company')
                            ->latest()
                            ->paginate(5),
            'stats' => [
                'companies' => Company::count(),
                'jobs' => Job::count(),
                'users' => User::count()
            ]
        ]);
    }
}