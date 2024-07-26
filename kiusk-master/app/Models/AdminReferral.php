<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class AdminReferral extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'count',
        'score',
    ];

    /**
     * transaction
     *
     * @return MorphTo
     */
    public function registeredReferral(): MorphOne
    {
        return $this->morphOne(RegisteredReferral::class, 'referralable');
    }
}
