<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company')
            ->latestPublished()
            ->filter(request()->only('position_type', 'salary', 'company', 'location'))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Home', [
            'filters' => request()->all(),
            'jobs' => $jobs,
        ]);
    }
}