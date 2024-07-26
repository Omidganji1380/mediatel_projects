<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $ids = [
            750, 751, 752, 753, 754, 755, 757, 758, 759, 760, 761, 762, 765, 766, 768, 771, 778, 783, 793, 794, 795, 796, 797, 798, 799, 800, 801, 802, 803, 804, 805, 806, 807, 808, 809, 810, 811, 812, 813, 814, 815, 816, 817, 819, 820, 823, 824, 825, 826, 827
        ];

        foreach($ids as $id){
            $data[] = [
                'ad_category_id' => 102,
                'ad_id' => $id,
                'is_main' => 1
            ];
        }
        DB::table('ad_category_pivot')->insert($data);
        $ids = [
            767, 772, 779, 821, 822
        ];

        foreach($ids as $id){
            $data[] = [
                'ad_category_id' => 101,
                'ad_id' => $id,
                'is_main' => 1
            ];
        }

        DB::table('ad_category_pivot')->insert($data);
    }
}
