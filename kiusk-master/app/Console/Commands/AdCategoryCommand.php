<?php

namespace App\Console\Commands;

use App\Models\Ad\Ad;
use Illuminate\Console\Command;

class AdCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad:update {old} {new}';

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
        $oldCat = $this->argument('old');
        $newCat = $this->argument('new');
        $ads = Ad::with([
            'mainCategory',
            'categories',
        ])
            ->whereHas('categories', function ($query) use($oldCat) {
                $ids = [$oldCat];
                return $query->whereIn('ad_category_id', $ids);
            })
            ->latest()->get();

            // dd($ads->count());

            $data = [];
            foreach($ads as $ad){
                $catIds =  $ad->categories->pluck('id')->toArray();
                // Find the index of the value 4
                $index = array_search($oldCat, $catIds);

                // If the value 4 is found in the array, replace it with 8
                if ($index !== false) {
                    $catIds[$index] = $newCat;
                }
                $ad->categories()->sync($catIds);
                dump($catIds);
            }
        dd("done");
    }
}
