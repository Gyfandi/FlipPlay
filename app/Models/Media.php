<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Media extends Model
{
    protected $fillable = [
        'title',
        'type',
        'release_year',
    ];

    public function animeDetail(): HasOne
    {
        return $this->hasOne(AnimeDetail::class);
    }

    public function mangaDetail(): HasOne
    {
        return $this->hasOne(MangaDetail::class);
    }

    public function lightNovelDetail(): HasOne
    {
        return $this->hasOne(LightNovelDetail::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'media_user')
            ->withTimestamps();
    }
}
