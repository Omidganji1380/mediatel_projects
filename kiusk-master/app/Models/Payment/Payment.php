<?php

namespace App\Models\Payment;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
 use HasFactory;

 protected $fillable = [
  'amount',
  'status',
  'extra',
  'user_id',
  'payable_type',
  'payable_id'
 ];
 /**
  * @var array<string, string>
  */
 protected $casts = [
  'extra' => 'array'
 ];

 public function payable(): MorphTo
 {
  return $this->morphTo();
 }

 public function user(): BelongsTo
 {
  return $this->belongsTo(User::class);
 }

 public function setExtraAttribute($value)
 {
  $this->attributes['extra'] = json_encode($value);
 }

 public function getExtraAttribute()
 {
  return json_decode($this->attributes['extra']);
 }
}