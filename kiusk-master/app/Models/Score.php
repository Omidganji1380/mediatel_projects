<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'score',
        'type',
        'current_role',
        'claimed',
        'spent',
        'spent_date',
        'referral_user_id',
        'extra',
    ];

    public const TYPES = [
        'comment',
        'review',
        'rate',
        'referral',
        'complete_registration',
        'google_review',
        'send_video',
        'service_usage'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'spent_date' => 'datetime',
        'claimed' => 'boolean',
        'spent' => 'boolean',
        'extra' => 'json'
    ];

    /**
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeClaimed($query)
    {
        $query->where('claimed', true);
    }

    public function scopeSpent($query)
    {
        $query->where('sent', true);
    }

    public function scopeNotSpent($query)
    {
        $query->where('sent', false);
    }
}
