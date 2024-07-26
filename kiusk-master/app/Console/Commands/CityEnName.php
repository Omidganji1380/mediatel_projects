<?php

namespace App\Console\Commands;

use App\Models\Address\City;
use App\Models\Address\State;
use Illuminate\Console\Command;

class CityEnName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'en:city';

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
        $states = State::all();
        foreach($states as $state){
            $state->update(['name_en' => $state->slug, 'slug' => strtolower($state->slug)]);
        }

        $cities = City::all();
        foreach($cities as $city){
            $city->update(['name_en' => $city->slug, 'slug' => strtolower($city->slug)]);
        }
        return 0;
    }
}
