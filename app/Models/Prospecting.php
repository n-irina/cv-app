<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prospecting extends Model
{
    use HasFactory;

    protected $fillable = [
        'contacts',
        'type',
        'subject',
        'createdBy',
        'observation',
        'note',
        'date',
    ];

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
}
