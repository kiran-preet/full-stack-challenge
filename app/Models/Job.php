<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;

    public $table = 'company_jobs';
    protected $fillable = [
        'company_id', 'title', 'description', 'position_type', 
        'location', 'salary_min', 'salary_max', 'salary_currency',
        'is_published', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at');
    }

    public function scopeLatestPublished($query)
    {
        return $query->published()
            ->orderBy('published_at', 'desc');
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['position_type'] ?? false, fn($query, $positionType) => 
            $query->where('position_type', $positionType)
        );

        $query->when($filters['salary'] ?? false, function($query, $salaryRange) {
            if ($salaryRange === '0-50000') {
                $query->where('salary_max', '<=', 50000);
            } elseif ($salaryRange === '50000-100000') {
                $query->whereBetween('salary_min', [50000, 100000]);
            } elseif ($salaryRange === '100000-150000') {
                $query->whereBetween('salary_min', [100000, 150000]);
            } elseif ($salaryRange === '150000+') {
                $query->where('salary_min', '>=', 150000);
            }
        });

        $query->when($filters['company'] ?? false, fn($query, $company) => 
            $query->whereHas('company', fn($query) => 
                $query->where('name', 'like', "%{$company}%")
            )
        );

        $query->when($filters['location'] ?? false, fn($query, $location) => 
            $query->where('location', 'like', "%{$location}%")
        );
    }
}
