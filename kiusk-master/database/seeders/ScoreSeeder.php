<?php

namespace Database\Seeders;

use App\Models\Score;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('user@score.com')->first();
        if ($user) {
            $user->update([
                'phone_verified_at' => now(),
                'email_verified_at' => now()
            ]);
            DB::beginTransaction();
            foreach (range(1, 100) as $key) {
                Score::create([
                    'user_id' => $user->id,
                    'type' => Arr::random(Score::TYPES),
                    'score' => Arr::random([1, 2, 5, 10, 25]),
                    'current_role' => $user->rule,
                    'claimed' => true
                ]);
            }
            DB::commit();
        }
    }
}
