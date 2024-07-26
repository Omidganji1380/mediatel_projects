<?php

namespace Database\Seeders;

use App\Models\Address\City;
use App\Models\Address\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('address_cities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $states = State::all();
        if (($open = fopen(public_path() . '/storage/canadacities.csv', "r")) !== FALSE) {
            $i = 0;
            $cities = [];
            while (($data = fgetcsv($open, 2000, ",")) !== FALSE) {
                if($i < 1 ){
                    $i++;
                    continue;
                }else{
                    $cities[] = $data[0];
                }

                City::create([
                    'name' => $data[0],
                    'slug' => $data[0],
                    'seo_title' => $data[0],
                    'state_id' => $states->where('name', $data[3])->first()->id,
                ]);
            }
            fclose($open);
        }
        echo "Done \r\n";

    }
}
