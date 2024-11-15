<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;

class Company extends Model
{
    use HasFactory;
    use HasTags;

    protected $fillable = [
        'name',
        'company_type',
        'legal_status',
        'SIRET_number',
    ];

    public function prospecting(): HasMany
    {
        return $this->hasMany(Prospecting::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}

