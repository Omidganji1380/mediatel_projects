<?php

namespace App\Console\Commands;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use Illuminate\Console\Command;

class UpdateAdsFeatured extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:featured';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ads = Ad::with([
            'state',
            'city',
            'mainCategory',
            'media' => function ($q) {
                $q->whereCollectionName('SpecialImage');
            },

    ])
    ->whereHas('mainCategory', function ($query){
        $ids = Category::pluck('id')->toArray();
        return $query->whereIn('ad_category_id', $ids);
    })
    ->whereIsVisible(true)
    ->withCount('favorites')->get();

        foreach($ads as $ad){
            $ad->update(['is_featured' => 1, 'is_sidebar_featured' => 1, 'is_suggestion_featured' => rand(0,1)]);
        }
        return 0;
    }
}
