<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimeDetail extends Model
{
    protected $fillable = [
        'media_id',
        'episodes',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
