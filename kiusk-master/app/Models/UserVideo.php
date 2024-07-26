<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserVideo extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * @var array<string, string>
     */
    protected $fillable = [
        'user_id',
        'is_confirmed',
    ];

     /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_confirmed' => 'boolean',
    ];

    /**
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
