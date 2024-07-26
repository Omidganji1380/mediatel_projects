<?php

namespace Database\Seeders;

use App\Models\Address\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('address_states')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        if (($open = fopen(public_path() . '/storage/canadacities.csv', "r")) !== FALSE) {
            $i = 0;
            $states = [];
            while (($data = fgetcsv($open, 2000, ",")) !== FALSE) {
                if($i < 1 ){
                    $i++;
                    continue;
                }else{
                    $states[] = $data[3];
                }
            }
            $states = array_unique($states);
            foreach($states as $state)
                State::create([
                    'name' => $state,
                    'slug' => $state,
                    'seo_title' => $state,
                ]);
            fclose($open);
        }

    }
}
