<?php

namespace Database\Seeders;

use App\Models\Ad\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealEstateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $realEstate = Category::where('slug', 'property')->first();
        $realEstatesRent = Category::where('name_en', 'LIKE', "%rent%")->descendantsAndSelf($realEstate->id);
        $realEstatesSale = Category::where('name_en', 'NOT LIKE', "%rent%")->descendantsAndSelf($realEstate->id);

        DB::beginTransaction();
            foreach ($realEstatesRent as $cat) {
                $cat->update(['sale_type' => 'rent']);

            }
            foreach ($realEstatesSale as $cat) {
                $cat->update(['sale_type' => 'sale']);
            }
        DB::commit();
    }
}
