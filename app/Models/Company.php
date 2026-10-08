<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'company_name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function generatedUrls(): HasMany
    {
        return $this->hasMany(GeneratedUrl::class);
    }
}
