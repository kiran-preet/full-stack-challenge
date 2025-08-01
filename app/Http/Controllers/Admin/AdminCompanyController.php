<?php

// app/Http/Controllers/CompanyController.php
namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class AdminCompanyController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Companies/Index', [
            'companies' => Company::withCount('jobs')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Companies/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url|max:255',
            'email' => 'required|email|unique:companies,email',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        Company::create($validated);

        return redirect()->route('admin.companies.index')->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        return Inertia::render('Admin/Companies/Show', [
            'company' => $company->loadCount('jobs'),
            'jobs' => $company->jobs()->latest()->paginate(5),
        ]);
    }

    public function edit(Company $company)
    {
        return Inertia::render('Admin/Companies/Edit', [
            'company' => $company,
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url|max:255',
            'email' => 'required|email|unique:companies,email,'.$company->id,
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('admin.companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Company deleted successfully.');
    }
}