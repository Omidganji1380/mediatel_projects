<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
 protected $table = 'payment_discounts';
 protected $fillable = [
  'id',
  'code',
  'amount',
  'percent',
  'payment_id'
 ];

 public function payment(): BelongsTo
 {
  return $this->belongsTo(Payment::class);
 }
}