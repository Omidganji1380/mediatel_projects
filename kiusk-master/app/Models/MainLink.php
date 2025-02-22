<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'link'
    ];

    public function redirect()
    {
        return $this->morphOne(Redirect::class, 'redirectable');
    }
}
