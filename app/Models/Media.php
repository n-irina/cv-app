<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'media_path',
        'type',
        'cv_id',
        'contract_id',
    ];

    protected $casts = [
        'media_path' => 'array',
    ];

    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function prospectings(): BelongsTo
    {
        return $this->belongsTo(Prospecting::class);
    }
}
