<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\Helper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerateUserReferralSeeder extends Seeder
{
    use Helper;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();


        DB::beginTransaction();

        foreach($users as $user){
            if(!$user->referralCode()->exists()){
                $referralCode = $this->generateReferralCode($user->id);
                $user->referralCode()->create([
                    'referral_code' => $referralCode
                ]);
            }
        }

        DB::commit();
    }
}
