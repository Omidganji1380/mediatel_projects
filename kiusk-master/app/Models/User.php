<?php

namespace App\Models;

use App\Models\Ad\Ad;
use App\Models\Ad\Favorite;
use App\Models\Ad\Report;
use App\Models\Ad\Review;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\Payment\Payment;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Illuminate\Auth\Passwords\CanResetPassword as MethodsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Interfaces\MustVerifyMobile as IMustVerifyMobile;
use App\Traits\MustVerifyMobile;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as IMustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasName, HasMedia, CanResetPassword, IMustVerifyMobile, IMustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use InteractsWithMedia;
    use MethodsCanResetPassword;
    use MustVerifyMobile;
    use MustVerifyEmail;
    use HasRoles;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'country_code',
        'phone',
        'lang',
        'birthday',
        'address',
        'business_name',
        'description',
        'rule',
        'email',
        'password',
        'referral_id',
        'telegram_id',
        'telegram_first_name',
        'telegram_last_name',
        'telegram_username',
        'telegram_last_message',
        'telegram_last_method',
        'telegram_next_method',
        'telegram_last_message_id',
        'telegram_last_request_id',
        'extra',
        'is_active',
        'last_online_at',
        'phone_verified_at',
        'email_verified_at',
        'phone_verify_code',
        'email_verify_code',
        'unread_message_notification_sent',
        'send_code_via_telegram',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name', 'full_phone','name_with_role' ,'has_password'];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'birthday' => 'date',
        'extra' => 'json',
        "last_online_at" => "datetime",
        "is_active" => "boolean",
    ];

    public const ROLES = [
        'admin' => 'ادمین',
        'super_admin' => 'سوپر ادمین',
        'customer' => 'مشترک',
        // 'subscriber' => 'مشترک',
        'seo' => 'مدیر سئو',
        'author' => 'نویسنده',
        'business_owner' => 'مالک بیزنس',
        'seller' => 'فروشنده کالا',
        'real_estate' => 'مشاور املاک',
        'property_applicant' => 'متقاضی ملک',
        'vip' => 'مشترک ویژه (VIP)'
    ];

    public const FRONT_USER_ROLES = [
        'customer' => 'مشترک',
        'business_owner' => 'مالک بیزنس',
        'seller' => 'فروشنده کالا',
        'real_estate' => 'مشاور املاک',
        'property_applicant' => 'متقاضی ملک',
        // 'vip' => 'مشترک ویژه (VIP)'
    ];

    public const REGISTRATION_PROGRESS = [
        'first_name' => 10,
        'last_name' => 10,
        'name' => 10,
        'phone' => 10,
        'email' => 10,
        'password' => 10,
        'email_verified_at' => 10,
        'phone_verified_at' => 10,
        'address' => 10,
        'avatar' => 10
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullPhoneAttribute()
    {
        return "{$this->country_code}{$this->phone}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameWithRoleAttribute()
    {
        if($this->first_name || $this->last_name){
            $name = "{$this->first_name} {$this->last_name}";
        }elseif($this->name){
            $name = $this->name;
        }elseif($this->email){
            $name = $this->email;
        }elseif($this->phone){
            $name = $this->phone;
        }else{
            $name = 'no name';
        }

        return $name . " - " . (self::ROLES[$this->rule ?: 'customer'] ?? __('messages.roles.customer'));
    }

    public function getHasPasswordAttribute() {
        return ! empty($this->attributes['password']);
    }

    public function canAccessFilament(): bool
    {
        return $this->rule === 'admin' || $this->rule === 'super_admin' ||  $this->rule === 'seo' ||  $this->rule === 'author';
    }

    public function getFilamentAvatarUrl(): ?string
    {
        $url = $this?->getFirstMedia('profile')?->getUrl('avatar');
        if ($url) {
            return addslashes($url);
        }

        return '';
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function setExtraAttribute($value)
    {
        if ($value) {
            $this->attributes['extra'] = json_encode($value);
        } else {
            $this->attributes['extra'] = json_encode([]);
        }
    }

    public function getExtraAttribute()
    {
        if (isset($this->attributes['extra'])) {
            return json_decode($this->attributes['extra']);
        }
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->crop(Manipulations::CROP_CENTER, 150, 150)
            ->performOnCollections('profile');
            // ->nonQueued();
        $this->addMediaConversion('video')
            ->crop(Manipulations::CROP_CENTER, 150, 150)
            ->performOnCollections('videos');
            // ->nonQueued();
    }

    public function getAvatarAttribute()
    {
        return $this->getFirstMedia('profile')?->getUrl('avatar');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Cart Relations
     *
     * @return HasOne
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * User has one plan
     *
     * @return HasOne
     */
    public function subscription()
    {
        return $this->hasOne(PlanSubscription::class, 'user_id');
    }

    /**
     * User has one plan
     *
     * @return
     */
    public function vipSubscription()
    {
        return $this->hasOne(PlanSubscription::class, 'user_id')->where('is_vip', true);
    }

    /**
     * User has many plans
     *
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(PlanSubscription::class, 'user_id');
    }

    /**
     * User has subscribed
     *
     * @return boolean
     */
    public function subscribed(): bool
    {
        if ($this->subscriptions()->exists()) {
            $now = Carbon::now();
            $subscription = $this->subscriptions()->latest()->first();
            if (
                $subscription->is_active
                && $now->isAfter($subscription->starts_at)
                && $now->isBefore($subscription->ends_at)
                && is_null($subscription->canceled_at)
                // && $this->subscriptionUsage()
            ) {
                return true;
            }
            return false;
        }
        return false;
    }

    //  /**
    //  * Subscription Usage
    //  *
    //  * @return boolean
    //  */
    // public function subscriptionUsage() :bool
    // {
    //     if($this->subscription->usage <= $this->subscription->plan->limit)
    //         return true;
    //     return false;
    // }

    /**
     * Subscription Usage
     *
     * @param boolean $featured
     * @return boolean
     */
    public function subscriptionUsage($featured = false): bool
    {
        $property = $featured ? "featured_" : "";
        if ($this->subscription->$property . "usage" <= $this->subscription->plan->$property . "limit")
            return true;
        return false;
        // if($this->subscription->usage <= $this->subscription->plan->limit)
        //     return true;
        // return false;
    }

    public function subscriptionUsageChecker()
    {
    }

    public function getCompleteProfileAttribute(): bool
    {
        return ($this->name &&
                $this->first_name &&
                $this->last_name &&
                $this->email &&
                $this->phone &&
                $this->email_verified_at &&
                $this->phone_verified_at &&
                $this->avatar &&
                $this->address &&
                $this->password) ? true : false;
    }

    /**
     *
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Returns user plan invoice period in days
     *
     * @return integer
     */
    public function subscriptionPeriod(): int
    {
        return $this->subscription->plan->invoice_period * Plan::INTERVALS_DAYS[$this->subscription->plan->invoice_interval];
    }

    /**
     * Check if user's language is farsi
     *
     * @return boolean
     */
    public function isLangFa(): bool
    {
        return $this->lang == 'fa';
    }

    public function referralCode(): HasOne
    {
        return $this->hasOne(Referral::class);
    }

    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class, 'referral_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function commentReviewScores()
    {
        return $this->scores()->where(function($query){
            $query->where('type', 'comment')
                ->orWhere('type', 'review');
        })->where('claimed', true)->where('spent', false);
    }

    public function registrationScores()
    {
        return $this->scores()->where('type', 'complete_registration')->where('claimed', true)->where('spent', false);
    }

    public function commentScores()
    {
        return $this->scores()->where('type', 'comment')->where('claimed', true)->where('spent', false);
    }

    public function rateScores()
    {
        return $this->scores()->where('type', 'rate')->where('claimed', true)->where('spent', false);
    }

    public function reviewScores()
    {
        return $this->scores()->where('type', 'review')->where('claimed', true)->where('spent', false);
    }

    public function referralScores()
    {
        return $this->scores()->where('type', 'referral')->where('claimed', true)->where('spent', false);
    }

    public function googleReviewScores()
    {
        return $this->scores()->where('type', 'google_review')->where('claimed', true)->where('spent', false);
    }

    public function sendVideoScores()
    {
        return $this->scores()->where('type', 'send_video')->where('claimed', true)->where('spent', false);
    }

    public function serviceUsageScores()
    {
        return $this->scores()->where('type', 'service_usage')->where('claimed', true)->where('spent', false);
    }

    public function totalClaimedScores()
    {
        return $this->scores()->where('claimed', true)->where('spent', false);
    }

    public function totalNotClaimedScores()
    {
        return $this->scores()->where('claimed', false)->where('spent', false);
    }

    public function totalSpentScores()
    {
        return $this->scores()->where('spent', true);
    }

    public function videos()
    {
        return $this->hasMany(UserVideo::class);
    }

    public function googleReview()
    {
        return $this->hasOne(GoogleReview::class);
    }

    /**
     * is active scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeIsActive($query)
    {
        $query->where('is_active', 1);
    }
}
