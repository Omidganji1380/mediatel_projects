<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class TicketCategory extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'parent_id',
        'is_visibile',
        'title_en',
        'description_en'
    ];

    public function parent()
    {
        return $this->belongsTo(TicketCategory::class, 'parent_id');
    }
}
