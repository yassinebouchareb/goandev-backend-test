<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['api_id', 'title', 'description', 'image_url', 'rating', 'release_date', 'from_api'];

    protected $casts = [
        'release_date' => 'date',
        'from_api' => 'boolean',
    ];

    /**
     * Retrieve the genres associated with this model.
     *
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class)->withTimestamps();
    }
}
