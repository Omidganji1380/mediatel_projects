<?php

namespace Database\Seeders;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        $categories = Category::all();

        foreach($categories as $category){
            $oldSlug = $category->slug;
            $newSlug = Str::slug($category->slug);
            $category->update([
                'old_slug' => $oldSlug,
                'slug' => $newSlug,
                'current_url' => route('front.ad.category.index.first.page', $newSlug),
                'old_url' => route('front.ad.category.index.first.page', $oldSlug),
            ]);
        }

        DB::commit();

        dd("done");
    }
}
