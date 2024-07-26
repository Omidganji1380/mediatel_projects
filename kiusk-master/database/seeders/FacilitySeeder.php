<?php

namespace Database\Seeders;

use App\Models\Ad\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('facilities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $facility = [
            'electricity' => 'برق',
            'Maintenance services' => 'خدمات تعمیر - نگهداری',
            'garbage service' => 'خدمات زباله',
            'Cleaning services' => 'خدمات نظافت',
            'Wastewater' => 'فاضلاب',
            'Furniture' => 'مبلمان',
            'gas' => 'گاز',
            'Parking ' => 'پارکینگ ',
            'Warehouse' => 'انباری',
            'Internet' => 'اينترنت',
            'Water' => 'آب',
            'cool' => 'سرمایش',
            'heating' => 'گرمايش',
            'TV' => 'TV',
        ];

        $nearby_facility = [
            'University' => 'دانشگاه',
            'Subway' => 'مترو',
            'School' => 'مدرسه',
            "Dog Park" => 'پارک سگ ها',
            'confectionery ' => 'شیرینی فروشی ',
            'liquor bar' => 'بار مشروب فروشی',
            'coffee shop' => 'قهوه خوری',
            'Swimming pool' => 'استخر',
            ' kindergarten' => ' مهد کودک',
            'shopping center ' => 'مرکز خرید ',
            "Grocery Store" => 'فروشگاه مواد غذایی',
            'School' => 'مدرسه',
            'highway' => ' بزرگراه',
            'walking pathway' => 'مسیر پیاده روی',
            'cycling line' => 'مسیر دوچرخه سواری',
            'bus station' => 'ایستگاه اتوبوس',
            'Bank' => 'بانک',
            'Hospital ' => 'بیمارستان ',
            'sport Club ' => 'باشگاه ورزشی ',
            'Theater' => 'تئاتر',
            'Library' => 'کتابخانه',
            'Restaurant' => 'رستوران',
            'Bakery' => 'نانوایی',
            'Park' => 'پارک',
            'Store' => 'فروشگاه',
        ];

        $building_facility = [
            'air conditioning system' => 'سیستم تهویه',
            "Home Appliances" => 'اسباب برقی خانگی',
            'Television ' => 'تلویزیون ',
            'Internet' => 'اینترنت',
            'Grill' => 'کباب پز',
            'freshly painted' => 'تازه رنگ شده ',
            'wardrobe' => 'کمد دیواری',
            "Dedicated thermostat" => 'ترموستات اختصاصی',
            'carpeted' => 'فرش شده',
            'CCTV' => 'دوربین مدار بسته',
            'dishwasher' => 'ماشین ظرف شویی',
            'curtain' => 'پرده',
            'fireplace' => 'شومینه',
            'And that ' => 'وان ',
            'Common yard' => 'حیاط اشتراکی',
            "private yard" => 'حیاط اختصاصی',
            'separate entry' => 'ورودی مجزا ',
            'Wheelchair access' => 'دسترسی به صندلی چرخ دار',
            'den' => 'den -دن',
            'Warehouse' => 'انباری',
            "danger notification system" => 'سیستم اعلان خطر',
            'Radiator' => 'رادیاتور ',
            'private pool' => 'استخر اختصاصی',
            'island' => 'جزیره',
            'newly renovated' => 'تازه بازسازی شده ',
            'garbage' => 'آشغالدانی',
            'hard wood' => 'چوب فشرده ',
            'laminated' => 'لمینیت شده',
            'floored' => 'کفپوش شده',
            'Ceramicized' => 'سرامیک  شده',
            "Shared washing machine and dryer" => ' لباسشویی خشک کن اشتراکی',
            "Private washer and dryer" => 'لباسشویی خشک کن اختصاصی ',
            'balcony' => 'بالکن',
            'Microwave' => 'ماکروفر',
            'air conditioner' => 'کولر',
            'furnished' => 'مبله',
        ];

        $unit_facility = [
            "Image iPhone" => ' آیفون تصویری ',
            "Has a construction worker" => 'دارای کارمند ساختمان',
            'concierge' => 'دربان ',
            'recycling section' => 'قسمت بازیافت ',
            "Building Facilities Center" => 'مرکز تاسیسات ساختمان',
            'entertainment room' => 'اتاق سرگرمی ',
            "Tater Room" => 'اتاق تئاتر',
            "Swimming pool on the roof of the building" => 'استخر روی پشت بام ساختمان',
            "Charger for electric cars" => 'شارژر مخصوص ماشین های الکتریکی ',
            'Air conditioning system ' => ' سیستم تهویه ',
            "building balcony" => 'بالکن ساختمان',
            "bike storage" => 'محل نگهداری دوچرخه',
            'garage' => 'گاراج ',
            "surveillance camera" => 'دوربین نظارتی',
            'tennis court' => 'زمین تنیس',
            'laundry room' => 'اتاق رختشویی',
            "Possibility to keep a pet" => 'امکان نگه داشتن حیوان خانگی',
            'guest room' => 'اتاق مهمان',
            'Elevator ' => 'آسانسور ',
            'sauna ' => 'سونا ',
            "Celebration and ceremony room" => 'اتاق جشن و مراسم',
            ' Warehouse' => ' انباری',
            "24-hour security" => 'امنیت ۲۴ ساعته',
            'Visitor Parking' => 'پارکينگ ويزيتور',
            "Building Manager" => 'مدير ساختمان',
            'Backyard' => 'حیاط خلوت',
            'Swimming pool' => 'استخر',
            'Jacuzzi' => 'جکوزی',
            "exercise room" => 'اتاق ورزش ',
            'incoming call' => 'زنگ ورودی ',
        ];

        $parking = [
            'No parking' => 'ندارد',
            'Garaj Parking' => 'گاراج',
            'Driveway Parking' => 'درایو وی',
            'Underground Parking' => 'زیر زمین',
            'Street Parking' => 'خیابان',
        ];

        $data = [];

        foreach($facility as $key => $value){
            $data[] = [
                'type' => 'facility',
                'fa_name' => $value,
                'en_name' => $key
            ];
        }
        foreach($nearby_facility as $key => $value){
            $data[] = [
                'type' => 'nearby_facility',
                'fa_name' => $value,
                'en_name' => $key
            ];
        }
        foreach($building_facility as $key => $value){
            $data[] = [
                'type' => 'building_facility',
                'fa_name' => $value,
                'en_name' => $key
            ];
        }
        foreach($unit_facility as $key => $value){
            $data[] = [
                'type' => 'unit_facility',
                'fa_name' => $value,
                'en_name' => $key
            ];
        }
        foreach($parking as $key => $value){
            $data[] = [
                'type' => 'parking',
                'fa_name' => $value,
                'en_name' => $key
            ];
        }

        foreach($data as $d){
            Facility::create($d);
        }
    }
}
