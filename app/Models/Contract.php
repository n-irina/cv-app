<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{

    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'start_date',
        'end_date',
        'signatories',
    ];

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function prospecting(): BelongsTo
    {
        return $this->belongsTo(Prospecting::class);
    }

}
