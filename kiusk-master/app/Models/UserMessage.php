<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UserMessage extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'user_count',
        'message',
        'all',
        'business_owner',
        'seller',
        'real_estate',
        'property_applicant',
        'extra',
    ];

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
