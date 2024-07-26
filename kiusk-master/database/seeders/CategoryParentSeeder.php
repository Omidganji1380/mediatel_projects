<?php

namespace Database\Seeders;

use App\Models\Ad\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = [
            0 => [
                'name' => 'بیزینس های IT',
                'name_en' => "IT businesses",
                'children' => [
                    'Web design and programming companies (Mediatel)' => 'شرکتهای برنامه نویسی و طراحی وب ( مدیاتل)',
                    'Design and graphic companies' => 'شرکت های طراحی و گرافیکی',
                    'Software services' => 'خدمات نرم افزاری',
                    'Digital marketing companies (Mediatel)' => 'شرکت های دیجیتال مارکتینگ (مدیاتل)',
                    'Computer repair services' => 'خدمات تعمیرات کامپیوتر',
                    'Mobile repair services' => 'خدمات تعمیرات موبایل',
                ]
            ],
            1 => [
                'name' => 'فروشگاه ها',
                'name_en' => 'stores',
                'children' => [
                    'Building materials store' => 'فروشگاه مصالح ساختمانی',
                    'Tool and hardware store' => 'فروشگاه ابزار و یراق',
                    'Boutique and clothing sales' => 'بوتیک و فروش لباس',
                    'Confectionery or sweet shop' => 'قنادی یا شیرینی فروشی',
                    'Bakery' => 'نانوایی',
                    'Medical equipment store' => 'فروشگاه تجهیزات پزشکی',
                    'Wholesale' => 'عمده فروشی',
                    'Home appliance store' => 'فروشگاه لوازم خانگی',
                    'Jewelry' => 'طلافروشی',
                    'florist' => 'گل فروشی',
                    'handicraft market' => 'فروشگاه صنایع دستی',
                    'Other stores' => 'دیگر فروشگاه ها',
                ]
            ],
            2 => [
                'name' => 'وکالت',
                'name_en' => 'lawyer',
                'children' => [
                    'Immigration lawyer' => 'وکیل مهاجرت',
                    'Lawyer for traffic offenses' => 'وکیل جرائم رانندگی',
                    'Criminal lawyer' => 'وکیل جرائم جنایی',
                    'Financial and tax lawyer' => 'وکیل امور مالی و مالیاتی',
                    'Business and trade lawyer' => 'وکیل بیزینس و تجارت',
                ]
            ],
            3 => [
                'name' => 'خدمات تولیدی و فنی',
                'name_en' => 'Manufacturing and technical services',
                'children' => [
                    'Cabinets' => 'کابینت',
                    'carpentry' => 'نجاری',
                    'piping' => 'لوله کشی',
                    'turner' => 'تراشکار',
                    'glass cutting' => 'شیشه بری',
                    'Industrial electricity services' => 'خدمات برق صنعتی',
                ]
            ],
            4 => [
                'name' => 'خدمات پزشکی',
                'name_en' => 'medical services',
                'children' => [
                    'Psychology' => 'روانشناسی',
                    'Physiotherapy' => 'فیزیوتراپی',
                    'clinic' => 'کلینیک',
                    'pharmacy' => 'داروخانه',
                    'Dental' => 'دندانپزشکی',
                    'veterinary medicine' => 'دامپزشکی',
                    'Laboratory' => 'آزمایشگاه',
                    'Home for the Aged' => 'خانه سالمندان',
                    'Optometry and glasses' => 'بینایی سنجی و عینک',
                ]
            ],
            5 => [
                'name' => 'مهندسی',
                'name_en' => 'engineering',
                'children' => [
                    'Engineering Management Office' => 'دفتر مدیریت مهندسی',
                    'Mapping Mapping Company' => 'شرکت نقشه کشی نقشه برداری',
                    'Quality control company' => 'شرکت کنترل کیفیت',
                    'Design and construction office' => 'دفتر طراحی و ساخت ',
                    'Contractor' => 'پیمانکار',
                ]
            ],
            6 => [
                'name' => 'خدمات مالی و حسابداری',
                'name_en' => 'Financial and accounting services',
                'children' => [
                    'Official accountant' => 'حسابدار رسمی',
                    'Accounting companies' => 'شرکت های حسابداری',
                    'Comercial companies' => 'شرکت های بازرگانی',
                    'Investment companies' => 'شرکت های سرمایه گذاری',
                ]
            ],
            7 => [
                'name' => 'خدمات عروسی و ایونت',
                'name_en' => 'Wedding and event services',
                'children' => [
                    'Studio / photography and videography' => 'آتلیه / عکاسی و فیلمبرداری',
                    'Lighting and fireworks services' => 'خدمات نورپردازی و آتش بازی',
                    'Ceremonies of assemblies' => ' تشریفات مجالس',
                    'Hall / Garden Hall / Mansion' => ' تالار / باغ تالار / عمارت',
                    'Flower arrangements and decorations' => ' گل آرایی و تزئینات',
                    'Event planner' => 'ایونت پلنر',
                    'birthday party' => 'مراسم تولد',
                ]
            ],
            8 => [
                'name' => 'زیبایی و سلامت',
                'name_en' => 'Beauty and health',
                'children' => [
                    'Beauty and makeup salon' => 'سالن زیبایی و آرایش',
                    'beauty clinic' => 'کلینیک زیبایی',
                    'sport Club' => 'باشگاه ورزشی',
                ]
            ],
            9 => [
                'name' => 'خدمات آموزشی',
                'name_en' => 'educational services',
                'children' => [
                    'music Academy' => 'آموزشگاه موسیقی',
                    'Educational school' => 'آموزشگاه درسی',
                    'Driving school and license' => 'آموزشگاه رانندگی و گواهینامه',
                ]
            ],
            10 => [
                'name' => 'سایر خدمات',
                'name_en' => 'other services',
                'children' => [
                    'Transportation and freight' => 'حمل و نقل و باربری',
                    'Babysitting agency' => 'آژانس پرستاری از بچه',
                    'Insurance' => 'بیمه',
                    'exchange' => 'صرافی',
                    'Loan services' => 'خدمات وام',
                    'Equipment rental' => 'اجاره تجهیزات',
                    'ISO standard' => 'ایزو استاندارد',
                    'Printing and packaging' => 'چاپ و بسته بندی',
                    'Iranian carpet cleaner' => 'قالیشویی ایرانی',
                    'Real estate consultant' => 'مشاور املاک',
                    'Travel Agency' => 'آژانس هواپیمایی',
                    'shopping center' => 'مراکز خرید',
                    'Security companies' => 'شرکت های امنیتی',
                    'Gas stations' => 'پمپ بنزین ها',
                ]
            ],
            11 => [
                'name' => 'خدمات اقامتی و تفریحی',
                'name_en' => 'Accommodation and entertainment services',
                'children' => [
                    'Hotel' => 'هتل',
                    'Motel' => 'متل',
                    'eco resort' => 'اقامتگاه بوم گردی',
                    'Bar' => 'بار',
                    'Clubs and nightclubs' => 'کلاب و نایت کلاب',
                    'Games and entertainment (entertainment complex)' => 'بازی و سرگرمی (مجتع سرگرمی)',
                    'Pool and swimming' => 'استخر و شنا',
                    'gallery' => 'گالری',
                    'the cinema' => 'سینما',
                ]
            ],
            12 => [
                'name' => 'رستوران و کافی شاپ',
                'name_en' => 'restaurant and coffee shop',
                'children' => [
                    'Restaurant' => 'رستوران',
                    'Coffee Shop' => 'کافی شاپ',
                    'catering' => 'کیترینگ',
                    'Bar' => 'بار',
                    'fast food' => 'فست فوود',
                ]
            ],
            13 => [
                'name' => 'خدمات ماشین و موتور',
                'name_en' => 'Car and motorcycle services',
                'children' => [
                    'tuning' => 'تیونینگ',
                    'rent' => 'رنت ',
                    'Car exhibition' => 'نمایشگاه ماشین',
                    'Auto Mechanic' => 'مکانیک خودرو',
                    'Car smoothing and painting' => 'صاف کاری و نقاشی خودرو',
                    'Oil Change' => 'تعویض روغنی',
                ]
            ],
            14 => [
                'name' => 'خدمات ساخت و ساز',
                'name_en' => 'Construction Services',
                'children' => [
                    'building painting' => 'نقاشی ساختمان',
                    'Building electrical services' => 'خدمات برق ساختمان',
                    'Drywall and framing' => 'درایوال و فریمینگ',
                    'tile installer' => 'کاشی‌کار',
                    'piping' => 'لوله کشی',
                    'Flooring installer' => 'نصاب کف‌پوش',
                ]
            ],
            15 => [
                'name' => 'مدارس و اموزشگاه',
                'name_en' => 'Schools and Training Centers',
                'children' => [
                    'High school schools' => 'مدارس دبیرستان',
                    'Primary schools' => 'مدارس ابتدایی',
                    'kindergarten' => 'مهدکودک',
                    'Language Schools' => 'اموزشگاه زبان',
                ]
            ]
        ];

        $parentId = Category::where('slug', 'iranian-businesses-in-canada')->firstOrFail();

        DB::beginTransaction();

        foreach($cats as $parentKey => $parentVal){
            $parentCategory = Category::firstOrCreate(
                [
                    'slug' => Str::slug($parentVal['name_en'])
                ],
                [
                    'name' => $parentVal['name'],
                    'name_en' => $parentVal['name_en'],
                    'is_visible' => 1,
                    'position' => 0,
                    'parent_id' => $parentId->id
                ]
            );
            foreach($parentVal['children'] as $key => $val){
                Category::updateOrCreate(
                    [
                        'slug' => Str::slug($key),
                    ],
                    [
                        'name' => $val,
                        'name_en' => $key,
                        'is_visible' => 1,
                        'position' => 0,
                        'parent_id' => $parentCategory->id
                    ]
                );
            }

        }

        DB::commit();
    }
}
