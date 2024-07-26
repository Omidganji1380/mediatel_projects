<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan_id', 'is_active', 'usage', 'featured_usage',
        'starts_at', 'ends_at', 'cancels_at', 'canceled_at', 'expired_at',
        'type', 'model_id', 'is_vip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
