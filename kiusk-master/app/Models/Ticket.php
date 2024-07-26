<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Ticket extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'ticket_category_id', 'user_id', 'title', 'message', 'status', 'priority', 'parent_id'
    ];

    public const STATUSES = [
        'pending' => 'در حال بررسی',
        'replied' => 'پاسخ داده شده'
    ];

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeParentList($query)
    {
        $query->whereNull('parent_id');
    }
}
