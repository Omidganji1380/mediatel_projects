<?php

namespace App\Models;

use App\Models\Ad\Ad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ServiceUsage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * @var array<string, string>
     */
    protected $fillable = [
        'user_id',
        'ad_id',
        'description',
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

    /**
     *
     * @return BelongsTo
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
