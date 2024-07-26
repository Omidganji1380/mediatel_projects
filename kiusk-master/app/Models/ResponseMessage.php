<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseMessage extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $fillable = [
        'responseable_id',
        'responseable_type',
        'message',
        'is_rejected',
    ];

    public function responseable()
    {
        return $this->morphTo();
    }
}
