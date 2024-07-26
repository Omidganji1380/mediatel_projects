<?php

namespace Database\Seeders;

use App\Models\Ad\Ad;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SpecialAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ads = Ad::where('is_featured', true)->where('is_visible', true)->get();
        $now = Carbon::now();
        $end = Carbon::now()->addDays(365);
        foreach($ads as $ad){
            $ad->update([
                'is_sidebar_featured' => true,
                'is_suggestion_featured' => true,
                'subscription_start_date' => $now,
                'subscription_end_date' => $end,
            ]);
        }
    }
}
