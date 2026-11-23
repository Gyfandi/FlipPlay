<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MangaDetail extends Model
{
    protected $fillable = [
        'media_id',
        'volumes',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
