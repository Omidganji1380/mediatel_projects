<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PaymentFactory extends Factory
{
 protected $model = Payment::class;

 public function definition(): array
 {
  return [
   'payable_id' => $this->faker->randomNumber(),
   'payable_type' => $this->faker->word(),
   'amount' => $this->faker->randomNumber(),
   'extra' => json_encode([
                           'toTop' => $this->faker->randomElement([
                                                                   true,
                                                                   false,
                                                                  ])
                          ]),
   'created_at' => Carbon::now(),
   'updated_at' => Carbon::now(),
  ];
 }
}
