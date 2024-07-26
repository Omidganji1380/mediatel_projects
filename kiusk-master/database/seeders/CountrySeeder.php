<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cc = file_get_contents(public_path('CountryCodes.json'));
        $cc = json_decode($cc, true);
        DB::table('countries')->insert($cc);
    }
}
