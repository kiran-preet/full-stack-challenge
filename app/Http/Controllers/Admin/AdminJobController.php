<?php

// app/Http/Controllers/JobController.php
namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class AdminJobController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Jobs/Index', [
            'jobs' => Job::with('company')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Jobs/Create', [
            'companies' => Company::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'position_type' => 'required|in:remote,in-person,hybrid',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|min:0|gte:salary_min',
            'salary_currency' => 'required|string|size:3',
            'is_published' => 'boolean',
        ]);

        if ($request->is_published) {
            $validated['published_at'] = now();
        }

        Job::create($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job created successfully.');
    }

    public function show(Job $job)
    {
        return Inertia::render('Admin/Jobs/Show', [
            'job' => $job->load('company'),
            'isAdmin' => auth()->user()?->is_admin ?? false,
        ]);
    }

    public function edit(Job $job)
    {
        return Inertia::render('Admin/Jobs/Edit', [
            'job' => $job,
            'companies' => Company::all(),
        ]);
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'position_type' => 'required|in:remote,in-person,hybrid',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'required|numeric|min:0',
            'salary_max' => 'required|numeric|min:0|gte:salary_min',
            'salary_currency' => 'required|string|size:3',
            'is_published' => 'boolean',
        ]);

        if ($request->is_published && !$job->is_published) {
            $validated['published_at'] = now();
        }

        $job->update($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully.');
    }
}
