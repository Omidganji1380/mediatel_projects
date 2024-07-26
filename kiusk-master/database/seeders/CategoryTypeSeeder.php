<?php

namespace Database\Seeders;

use App\Models\Ad\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $realEstate = Category::where('slug', 'property')->first();
        $realEstates = Category::descendantsAndSelf($realEstate->id);

        $sell = Category::where('slug', 'buying-and-selling-new-and-used-goods')->first();
        $sells = Category::descendantsAndSelf($sell->id);

        $business = Category::where('slug', 'iranian-businesses-in-canada')->first();
        $businesses = Category::descendantsAndSelf($business->id);

        DB::beginTransaction();
            foreach($realEstates as $cat){
                $cat->update(['type' => 'real_estate']);
            }
            foreach($sells as $cat){
                $cat->update(['type' => 'seller']);
            }
            foreach($businesses as $cat){
                $cat->update(['type' => 'business_owner']);
            }
        DB::commit();
    }
}
