<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    /**
     *
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'score_category_id',
        'score',
        'confirmed',
        'used',
        'code',
        'url',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'confirmed' => 'boolean',
        'used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scoreCategory()
    {
        return $this->belongsTo(ScoreCategory::class);
    }

}
