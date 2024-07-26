<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoogleLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rating',
        'title',
        'url',
        'reply',
        'is_confirmed',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
