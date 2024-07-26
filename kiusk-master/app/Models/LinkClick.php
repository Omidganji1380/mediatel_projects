<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkClick extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $fillable = [
        'clickable_id',
        'clickable_type',
        'click_count',
        'url'
    ];

    public function clickable()
    {
        return $this->morphTo();
    }
}
