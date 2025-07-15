<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia; 

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs/{job}', [AdminJobController::class, 'show'])->name('jobs.show');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Companies
    Route::resource('companies', AdminCompanyController::class);
    
    Route::post('/companies/{company}', [AdminCompanyController::class, 'update'])
         ->name('admin.companies.update');
    // Jobs
    Route::resource('jobs', AdminJobController::class);
    
    // Additional company-specific job routes
    Route::get('/companies/{company}/jobs/create', [AdminJobController::class, 'createForCompany'])
         ->name('admin.companies.jobs.create');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';