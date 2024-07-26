<?php

namespace App\Console\Commands;

use App\Models\Ad\Category;
use Illuminate\Console\Command;

class CategoryEnName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'en:category';

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
        $names = [
            1 => "Other" ,
            2 => "loan affairs" ,
            3 => "advice" ,
            4 => "Graphic Affairs and Advertising" ,
            5 => "Beauty Services" ,
            6 => "Doctor" ,
            7 => "DJ and Music" ,
            8 => "Carpet cleaning" ,
            9 => "Lawyer and legal services" ,
            10 => "confectionary" ,
            11 => "Accounting" ,
            12 => "Exchange" ,
            13 => "florist" ,
            14 => "Travel and accommodation services" ,
            15 => "Supermarket and food" ,
            16 => "financial advice" ,
            17 => "Photography and video recording" ,
            18 => "Restaurant" ,
            19 => "Immigration Services" ,
            20 => "Transportation" ,
            21 => "Insurance" ,
            22 => "Sweets and nuts" ,
            23 => "Accounting" ,
            24 => "Building services" ,
            25 => "Other jobs" ,
            26 => "property" ,
            27 => "residential sale" ,
            28 => "residential rental" ,
            29 => "commercial sale" ,
            30 => "commercial lease" ,
            31 => "Performing buying and selling and renting" ,
            32 => "personal items" ,
            33 => "Bags, shoes and clothes" ,
            34 => "decorative" ,
            35 => "Cosmetics, health, therapy" ,
            36 => "Children's shoes and clothes" ,
            37 => "Ornaments" ,
            38 => "for business" ,
            39 => "Wholesale" ,
            40 => "equipment and machinery" ,
            41 => "shop and shop" ,
            42 => "Barbershop and beauty salons" ,
            43 => "industrial" ,
            44 => "Coffee shop and restaurant" ,
            45 => "office" ,
            46 => "Electronics" ,
            47 => "Mobile and Tablet" ,
            48 => "Mobile" ,
            49 => "Tablet" ,
            50 => "Mobile and tablet accessories" ,
            51 => "SIM card" ,
            52 => "Other" ,
            53 => "Computer and laptop" ,
            54 => "Console, video game and online" ,
            55 => "Video and Audio" ,
            56 => "desk phone" ,
            57 => "Other" ,
            58 => "Household" ,
            59 => "Kitchenware" ,
            60 => "etc" ,
            61 => "car" ,
            62 => "the mechanic" ,
            63 => "car sales" ,
            64 => "educational" ,
            65 => "School" ,
            66 => "Tutoring" ,
            67 => "Specialized Courses" ,
        ];

        foreach($names as $key => $value){
            Category::find($key)?->update(['name_en' => $value]);
        }
    }
}
