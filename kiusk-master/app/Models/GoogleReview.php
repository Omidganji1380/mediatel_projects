<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoogleReview extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $fillable = [
        'user_id',
        'url',
        'is_confirmed',
        'is_promoted',
        'google_ref',
        'rating',
        'comment',
        'title',
        'url',
        'name',
        'photo',
        'extra',
        'reviewed_at',
        'review_updated_at',
        'reply',
        'is_displayable',
        'is_photo_displayable',
        'is_confirmed',
        'google_link_id',
    ];


    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_confirmed' => 'boolean',
        'is_promoted' => 'boolean',
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
