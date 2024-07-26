<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_fa',
        'dial_code',
        'code',
    ];

    protected $appends = ['name_with_code'];

    public function getNameWithCodeAttribute()
    {
        return $this->dial_code . ' ' . $this->name;
    }
}
