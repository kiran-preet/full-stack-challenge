<?php
// app/Models/Company.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'website', 'email'];

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}