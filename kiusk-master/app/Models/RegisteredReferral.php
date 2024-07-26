<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RegisteredReferral extends Model
{
    use HasFactory;

     /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'referralable_type',
        'referralable_id',
        'score',
    ];

    /**
     * @return MorphTo
     */
    public function referralable() : MorphTo
    {
        return $this->morphTo();
    }
}
