<?php

namespace Database\Seeders;

use App\Models\Ad\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parents = Category::where('parent_id', null)
            ->where('slug', '!=', 'iranian-businesses-in-canada')
            ->where('slug', '!=', 'property')
            ->get();
        // dd($parents->pluck('name'));
        $buyAndSell = Category::create(
            [
                'name' => "خرید و فروش کالای نو و کارکرده",
                'name_en' => "Buying and selling new and used goods",
                'slug' => Str::slug("Buying and selling new and used goods"),
                'is_visible' => 1,
                'position' => 0,
            ]
        );

        foreach($parents as $parent){
            $parent->update(['parent_id' => $buyAndSell->id]);
        }
    }
}
