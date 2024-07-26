<?php

namespace Database\Seeders;

use App\Models\Ad\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryNestedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        DB::beginTransaction();

        $i = 1;
        foreach($categories as $category){
            $category->update([
                '_lft' => $i,
                '_rgt' => ++$i
            ]);
            $i++;
        }

        foreach($categories as $category){
            if($category->id != 407){
                $parentId = $category->parent_id;
                $category->update(['parent_id' => 407]);
                $category->update(['parent_id' => $parentId]);
            }
        }
        DB::commit();
        dump("Done");
    }
}
