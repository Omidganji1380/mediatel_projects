<?php

namespace App\Console\Commands;

use App\Models\Ad\Ad;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCitiesAndStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:states';

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
        $switchStates = [
            2 => 3,
            3 => 2,
            4 => 2,
            5 => 6,
        ];

        $switchCities = [
            1 => 3,
            2 => 1,
            3 => 6,
            4 => 9,
            5 => 17,
        ];

        DB::beginTransaction();

        foreach($switchStates as $key => $value)
            Ad::where('state_id', $key)->update(['state_id' => $value]);

        foreach($switchCities as $key => $value)
            Ad::where('city_id', $key)->update(['city_id' => $value]);

        DB::commit();

        dump("Done");

        // $states = [
        //     "انتاریو"  => "Ontario",
        //     "آلبرتا"  => "Alberta",
        //     "بریتیش کلمبیا"  => "British Columbia",
        //     "مانیتوبا"  => "Manitoba",
        //     "نیوبرانزویک"  => "New Brunswick",
        //     "نیوفاندلند و لابرادور"  => "Newfoundland and Labrado",
        //     "نوا اسکوشیا"  => "Nova Scotia",
        //     "جزیره پرنس ادوارد"  => "Prince Edward Islan",
        //     "کبک"  => "Quebec",
        //     "ساسکاچوان"  => "Saskatchewan",
        // ];

        // $cities = [
        //     "تورنتو" => "Toronto",
        //     "ادمونتون" => "Edmonton",
        //     "ویکتوریا" => "Victoria",
        //     "وینیپگ" => "Winnipeg",
        //     "فردریکتون" => "Fredericton",
        //     "سنت جانز" => "St. John's",
        //     "هالیفاکس" => "Halifax",
        //     "شارلوت‌تاون" => "Charlottetown",
        //     "کبک" => "Quebec City",
        //     "رجاینا" => "Regina",
        // ];

        return 0;
    }
}
