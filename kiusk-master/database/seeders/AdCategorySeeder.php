<?php

namespace Database\Seeders;

use App\Models\Ad\Ad;
use Illuminate\Database\Seeder;

class AdCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oldCat = 1;
        $newCat = 1;
        $ads = Ad::with([
            'state',
            'city',
            'mainCategory',
            'categories',
            'media' => function ($q) {
                $q->whereCollectionName('SpecialImage');
            },
            'favorites' => function ($q) {
                if (auth()->check()) {
                    $q->whereUserId(auth()->id());
                }
            }
        ])
            ->whereHas('categories', function ($query) {
                $ids = [$oldCat];
                return $query->whereIn('ad_category_id', $ids);
            })
            ->latest()->take(4)->get();

            $data = [];
            foreach($ads as $ad){
                $catIds =  $ad->categories->pluck('id')->toArray();
                dump($catIds);
                // Find the index of the value 4
                $index = array_search($oldCat, $catIds);

                // If the value 4 is found in the array, replace it with 8
                if ($index !== false) {
                    $catIds[$index] = $newCat;
                }
                // $ad->categories()->sync();
                dump($catIds);
            }
        dd($data);
    }
}
