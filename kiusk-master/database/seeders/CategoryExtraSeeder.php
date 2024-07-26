<?php

namespace Database\Seeders;

use App\Models\Ad\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CategoryExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $ids = Arr::flatten(s()->mainPageCategories);
        // $categories = Category::with(['ads'])
        // ->whereIn('id', $ids)
        // ->orderByRaw("FIELD(id, " . implode(',', $ids) . ")")
        // ->get();


        // $extra = json_decode(json_encode($cat->extra), false);

        // dd($extra->BlogText_2->positions);

        $categories = Category::all();
        $homebg1 = [
            'positions' => [
                'en' => [
                    'title' => [
                        'x' => 340,
                        'y' => 35,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 340,
                        'y' => 100,
                        'size' => 18,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 1074,
                        'y' => 125,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 1074,
                        'y' => 125,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 1074,
                        'y' => 88,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
                'fa' => [
                    'title' => [
                        'x' => 940,
                        'y' => 35,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 940,
                        'y' => 100,
                        'size' => 18,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 1074,
                        'y' => 125,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 1074,
                        'y' => 125,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 1074,
                        'y' => 88,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
            ]
        ];
        $homebg2 = [
            'positions' => [
                'en' => [
                    'title' => [
                        'x' => 340,
                        'y' => 35,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 340,
                        'y' => 100,
                        'size' => 18,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 1074,
                        'y' => 125,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 1074,
                        'y' => 125,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 1074,
                        'y' => 88,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
                'fa' => [
                    'title' => [
                        'x' => 940,
                        'y' => 35,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 940,
                        'y' => 100,
                        'size' => 18,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 1074,
                        'y' => 125,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 1074,
                        'y' => 125,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 1074,
                        'y' => 88,
                        'size' => 24,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
            ]
        ];

        $betweemBlogs1 = [
            'positions' => [
                'en' => [
                    'title' => [
                        'x' => 35,
                        'y' => 24,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 35,
                        'y' => 83,
                        'size' => 12,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 387,
                        'y' => 96,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 1074,
                        'y' => 130,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 387,
                        'y' => 68,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
                'fa' => [
                    'title' => [
                        'x' => 400,
                        'y' => 17,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 333,
                        'y' => 83,
                        'size' => 12,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 387,
                        'y' => 96,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 1074,
                        'y' => 130,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 387,
                        'y' => 68,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
            ]
        ];

        $betweemBlogs2 = [
            'positions' => [
                'en' => [
                    'title' => [
                        'x' => 35,
                        'y' => 24,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 35,
                        'y' => 83,
                        'size' => 12,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 385,
                        'y' => 96,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 1074,
                        'y' => 130,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 385,
                        'y' => 68,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
                'fa' => [
                    'title' => [
                        'x' => 400,
                        'y' => 17,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 333,
                        'y' => 83,
                        'size' => 12,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 387,
                        'y' => 96,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 1074,
                        'y' => 130,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 387,
                        'y' => 68,
                        'size' => 14,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
            ]
        ];

        $blogBottom1 = [
            'positions' => [
                'en' => [
                    'title' => [
                        'x' => 160,
                        'y' => 130,
                        'size' => 38,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 140,
                        'y' => 355,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 193,
                        'y' => 881,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 193,
                        'y' => 893,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 193,
                        'y' => 800,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
                'fa' => [
                    'title' => [
                        'x' => 1050,
                        'y' => 130,
                        'size' => 38,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 1050,
                        'y' => 355,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 190,
                        'y' => 881,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 190,
                        'y' => 893,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 190,
                        'y' => 800,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
            ]
        ];
        $blogBottom2 = [
            'positions' => [
                'en' => [
                    'title' => [
                        'x' => 160,
                        'y' => 130,
                        'size' => 38,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 140,
                        'y' => 355,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 193,
                        'y' => 881,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 193,
                        'y' => 893,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 193,
                        'y' => 800,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
                'fa' => [
                    'title' => [
                        'x' => 1050,
                        'y' => 130,
                        'size' => 38,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 1050,
                        'y' => 355,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 190,
                        'y' => 881,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 190,
                        'y' => 893,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 190,
                        'y' => 800,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
            ]
        ];
        $blogSidebar1 = [
            'positions' => [
                'en' => [
                    'title' => [
                        'x' => 160,
                        'y' => 130,
                        'size' => 38,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 140,
                        'y' => 355,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 193,
                        'y' => 881,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 193,
                        'y' => 893,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 193,
                        'y' => 800,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
                'fa' => [
                    'title' => [
                        'x' => 1050,
                        'y' => 130,
                        'size' => 38,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 1050,
                        'y' => 355,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 190,
                        'y' => 881,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 190,
                        'y' => 893,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 190,
                        'y' => 800,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
            ]
        ];
        $blogSidebar2 = [
            'positions' => [
                'en' => [
                    'title' => [
                        'x' => 160,
                        'y' => 130,
                        'size' => 38,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 140,
                        'y' => 355,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 193,
                        'y' => 881,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 193,
                        'y' => 893,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 193,
                        'y' => 800,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
                'fa' => [
                    'title' => [
                        'x' => 1050,
                        'y' => 130,
                        'size' => 38,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'description' => [
                        'x' => 1050,
                        'y' => 355,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'right',
                        'valign' => 'top',
                    ],
                    'phone_1' => [
                        'x' => 190,
                        'y' => 881,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'phone_2' => [
                        'x' => 190,
                        'y' => 893,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                    'website' => [
                        'x' => 190,
                        'y' => 800,
                        'size' => 35,
                        'color' => '#000',
                        'align' => 'left',
                        'valign' => 'top',
                    ],
                ],
            ]
        ];

        $extra = [
            'HomeBGLarge_1' => $homebg1,
            'HomeBGLarge_2' => $homebg2,
            'BlogBottom_1' => $blogBottom1,
            'BlogBottom_2' => $blogBottom2,
            'BlogText_1' => $betweemBlogs1,
            'BlogText_2' => $betweemBlogs2,
            'BlogSidebar_1' => $blogSidebar1,
            'BlogSidebar_2' => $blogSidebar2,
        ];

        foreach($categories as $category){
            $category->update(['extra' => $extra]);
        }
    }
}
