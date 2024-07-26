<?php

namespace App\Models;

use App\Models\Ad\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStatus\HasStatuses;

class TelegramAd extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasStatuses;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'description_en',
        'image_url',
        'image_en_url',
        'link',
        'is_approved',
        'ad_type',
        'views',
        'is_paid',
    ];

    public const TYPES = [
        'customer' => 'customer',
        'business_owner' => 'business_owner',
        'real_estate' => 'real_estate',
        'seller' => 'seller',
        'property_applicant' => 'property_applicant',
        'vip' => 'vip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function adminMessage()
    {
        return $this->morphMany(AdminMessage::class, 'model');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function log()
    {
        return $this->morphOne(Log::class, 'loggable')->orderByDesc('created_at');
    }

    /**
     * Is Approved Scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeIsApproved($query)
    {
        $query->where('is_approved', 1);
    }

    /**
     * Is Approved Scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeIsPaid($query)
    {
        $query->where('is_paid', 1);
    }
}
