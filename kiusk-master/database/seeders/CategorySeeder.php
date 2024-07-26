<?php

namespace Database\Seeders;

use App\Models\Ad\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = [
            "house-and-earth" => [
                [
                    'name' => 'فروش مسکونی',
                    'name_en' => "sell-house",
                    'children' => [
                        'sale apartment' => 'آپارتمان',
                        'sale house and villa' => 'خانه و ویلا',
                        'sale Lands' => 'زمین و کلنگی',
                    ]
                ],
                [
                    'name' => 'اجاره مسکونی',
                    'name_en' => "Residential rental",
                    'children' => [
                        'rent apartment' => 'آپارتمان',
                        'rent house and villa' => 'خانه و ویلا',
                    ]
                ],
                [
                    'name' => 'فروش اداری و تجاری',
                    'name_en' => "Administrative and commercial sales",
                    'children' => [
                        'office, office room and office' => 'دفتر کار، اتاق اداری و مطب',
                        'Shops and booths' => 'مغازه و غرفه',
                        'Industrial, agricultural and commercial' => 'صنعتی،‌ کشاورزی و تجاری',
                    ]
                ],
                [
                    'name' => 'اجاره اداری و تجاری',
                    'name_en' => "Office and commercial rent",
                    'children' => [
                        'rent office, office room and office' => 'دفتر کار، اتاق اداری و مطب',
                        'rent Shops and booths' => 'مغازه و غرفه',
                        'rent Industrial, agricultural and commercial' => 'صنعتی،‌ کشاورزی و تجاری',
                    ]
                ],
                [
                    'name' => 'اجاره کوتاه مدت',
                    'name_en' => "Short term rental",
                    'children' => [
                        'Apartments and suites' => 'آپارتمان و سوئیت',
                        'Villa and garden' => 'ویلا و باغ',
                        'Office and training space' => 'دفتر کار و فضای آموزشی',
                    ]
                ],
                [
                    'name' => 'پروژه‌های ساخت و ساز',
                    'name_en' => "Construction projects",
                    'children' => [
                        'Participation in construction' => 'مشارکت در ساخت',
                        'Presell' => 'پیش‌فروش',
                    ]
                ],
            ],
            "vihacles" => [
                [
                    'name' => 'موتورسیکلت',
                    'name_en' => "motorcycle",
                    'children' => []
                ],
                [
                    'name' => 'قطعات یدکی و لوازم جانبی',
                    'name_en' => "Spare parts and accessories",
                    'children' => []
                ],
                [
                    'name' => 'قایق و سایر وسایل نقلیه',
                    'name_en' => "Boats and other vehicles",
                    'children' => []
                ],
                [
                    'name' => 'خودرو',
                    'name_en' => 'فروش-ماشین',
                    'children' => [
                        'car' => 'سواری',
                        'classic car' => 'کلاسیک',
                        'rental car' => 'اجاره‌ای',
                        'Heavy Vehicle' => 'سنگین',
                    ]
                ],
            ],
            "digital-goods" => [
                [
                    'name' => 'موبایل و تبلت',
                    'name_en' => 'Mobile and Tablet',
                    'children' => [
                        'cellphone' => 'گوشی موبایل',
                        'Tablet' => 'تبلت',
                        'Mobile and tablet accessories' => 'لوازم جانبی موبایل و تبلت',
                    ]
                ],
                [
                    'name' => 'رایانه',
                    'name_en' => 'computers',
                    'children' => [
                        'Desktop Computer' => 'کامپیوتر',
                        'Laptop' => 'لپ تاپ',
                        'parts and accessories' => 'قطعات و لوازم جانبی',
                        'Modem and network equipment' => 'مودم و تجهیزات شبکه',
                        'Printer/scanner/copier/fax' => 'پرینتر/اسکنر/کپی/فکس',
                    ]
                ],
                [
                    'name' => 'کنسول، بازی‌ ویدئویی و آنلاین',
                    'name_en' => 'Console, video game and online',
                    'children' => []
                ],
                [
                    'name' => 'صوتی و تصویری',
                    'name_en' => 'Video and Audio',
                    'children' => [
                        'Film and music' => 'فیلم و موسیقی',
                        'Photography and video camera' => 'دوربین عکاسی و فیلم‌برداری',
                        'Portable player' => 'پخش‌کننده همراه',
                        'Home audio system' => 'سیستم صوتی خانگی',
                        'Video and DVD player' => 'ویدئو و پخش کننده DVD',
                        'TV and projector' => 'تلویزیون و پروژکتور',
                        'CCTV' => 'دوربین مداربسته',
                    ]
                ],
                [
                    'name' => 'تلفن رومیزی',
                    'name_en' => 'Desk phone',
                    'children' => []
                ],
                [
                    'name' => 'لوازم خانگی برقی',
                    'name_en' => 'Electric household appliances',
                    'children' => [
                        'Refrigerator and Freezer' => 'یخچال و فریزر',
                        'Water cooler and water purifier' => 'آب‌سردکن و تصفیه آب',
                        'Washing machine and clothes dryer' => 'ماشین لباسشویی و خشک‌کن لباس',
                        'dishwasher' => 'ماشین ظرفشویی',
                        'Vacuum cleaner, vacuum cleaner and steam cleaner' => 'جاروبرقی، جاروشارژی و بخارشو',
                        'Iron and iron accessories' => 'اتو و لوازم اتو',
                        'Juice and fruit juice' => 'آبمیوه و آب‌مرکبات‌گیر',
                        'Chopper, grinder and food processor' => 'خردکن، آسیاب و غذاساز',
                        'Samavar, tea and coffee maker' => 'سماور، چای‌ساز و قهوه‌ساز',
                        'Gas stove and electric cooking appliances' => 'اجاق گاز و لوازم برقی پخت‌وپز',
                        'Hood' => 'هود',
                        'Other electrical appliances' => 'سایر لوازم برقی',
                    ]
                ],
            ],
            "home-and-kitchen" => [
                [
                    'name' => 'ظروف و لوازم آشپزخانه',
                    'name_en' => 'Kitchen utensils and appliances',
                    'children' => [
                        'Tablecloth, towel and kitchen towel' => 'سفره، حوله و دستمال آشپزخانه',
                        'Drainer and dish organizer' => 'آب‌چکان و نظم‌دهنده ظروف',
                        'Teapot, kettle and manual coffee maker' => 'قوری، کتری و قهوه‌ساز دستی',
                        'Serving dishes' => 'ظروف سرو و پذیرایی',
                        'Containers, plastic and disposable' => 'ظروف نگهدارنده، پلاستیکی و یکبارمصرف',
                        'Cooking utensils' => 'ظروف پخت‌وپز',
                    ]
                ],
                [
                    'name' => 'خوردنی و آشامیدنی',
                    'name_en' => 'Eating and drinking',
                    'children' => []
                ],
                [
                    'name' => 'خیاطی و بافتنی',
                    'name_en' => 'Sewing and knitting',
                    'children' => [
                        'Sewing machine and spinning' => 'چرخ خیاطی و ریسندگی',
                        'Sewing and knitting supplies' => 'لوازم خیاطی و بافتنی',
                    ]
                ],
                [
                    'name' => 'مبلمان و صنایع چوب',
                    'name_en' => 'Furniture and wood industry',
                    'children' => [
                        'Home furniture and table' => 'مبلمان خانگی و میزعسلی',
                        'Dining table and chairs' => 'میز و صندلی غذاخوری',
                        'Buffet, showcase and console' => 'بوفه، ویترین و کنسول',
                        'Library, shelf and wall shelves' => 'کتابخانه، شلف و قفسه‌های دیواری',
                        'Shoe rack, closet and drawer' => 'جاکفشی، کمد و دراور',
                        'Bed and bedding' => 'تخت و سرویس خواب',
                        'phone desk' => 'میز تلفن',
                        'TV Stand' => 'میز تلویزیون',
                        'Desk and computer' => 'میز تحریر و کامپیوتر',
                        'office furniture' => 'مبلمان اداری',
                        'Chairs and benches' => 'صندلی و نیمکت',
                    ]
                ],
                [
                    'name' => 'نور و روشنایی',
                    'name_en' => 'Light and brightness',
                    'children' => [
                        'Chandeliers and pendant lights' => 'لوستر و چراغ آویز',
                        'Bedside lamp and lampshade' => 'چراغ خواب و آباژور',
                        'String and decorative lights' => 'ریسه و چراغ تزئینی',
                        'Lamps and lights' => 'لامپ و چراغ',
                    ]
                ],
                [
                    'name' => 'فرش، گلیم و موکت',
                    'name_en' => 'Carpets, rugs and carpets',
                    'children' => [
                        'Carpet' => 'فرش',
                        'carpet panel' => 'تابلو فرش',
                        'carpet' => 'روفرشی',
                        'a priest' => 'پادری',
                        'carpet' => 'موکت',
                        'Glim, Jajim and Gebe' => 'گلیم، جاجیم و گبه',
                        'the back' => 'پشتی',
                    ]
                ],
                 [
                    'name' => 'تشک، روتختی و رختخواب',
                    'name_en' => 'Mattress, bedspread and bed',
                    'children' => [
                        'Beds, pillows and blankets' => 'رختخواب، بالش و پتو',
                        'bed mattress' => 'تشک تختخواب',
                        'Bedding service' => 'سرویس روتختی',
                    ]
                ],
                 [
                    'name' => 'لوازم دکوری و تزئینی',
                    'name_en' => 'Decorative accessories',
                    'children' => [
                        'Curtains, runners and tablecloths' => 'پرده، رانر و رومیزی',
                        'Mirror' => 'آینه',
                        'Decorative wall clock' => 'ساعت دیواری و تزئینی',
                        'Paintings, paintings and photographs' => 'تابلو، نقاشی و عکس',
                        'Statues, statues and replicas' => 'مجسمه، تندیس و ماکت',
                        'Artificial Flower' => 'گل مصنوعی',
                        'Natural flowers and plants' => 'گل و گیاه طبیعی',
                        'Handicrafts and other decorative items' => 'صنایع دستی و سایر لوازم تزئینی',
                    ]
                ],
                 [
                    'name' => 'تهویه، سرمایش و گرمایش',
                    'name_en' => 'Ventilation, cooling and heating',
                    'children' => [
                        'Water heater, package and heater' => 'آبگرمکن، پکیج و شوفاژ',
                        'Boiler, heater and fireplace' => 'بخاری، هیتر و شومینه',
                        'Water Cooler' => 'کولر آبی',
                        'Air conditioner and fan coil' => 'کولر گازی و فن‌کوئل',
                        'Fan and air purifier' => 'پنکه و تصفیه‌کنندهٔ هوا',
                    ]
                ],
                 [
                    'name' => 'شست‌وشو و نظافت',
                    'name_en' => 'Washing and cleaning',
                    'children' => [
                        'Detergents and paper towels' => 'مواد شوینده و دستمال کاغذی',
                        'Cleaning supplies' => 'لوازم نظافت',
                        'Clothes hanger and clothes hanger' => 'بندرخت و رخت‌آویز',
                    ]
                ],
                 [
                    'name' => 'حمام و سرویس بهداشتی',
                    'name_en' => 'Bathroom and toilet',
                    'children' => [
                        'Bathroom accessories' => 'لوازم حمام',
                        'Sanitary ware' => 'لوازم سرویس بهداشتی',
                    ]
                ],
            ],
            "services" => [
                [
                    'name' => 'موتور و ماشین',
                    'name_en' => 'Engine and car',
                    'children' => []
                ],
                [
                    'name' => 'پذیرایی/مراسم',
                    'name_en' => 'reception/ceremony',
                    'children' => []
                ],
                [
                    'name' => 'خدمات رایانه‌ای و موبایل',
                    'name_en' => 'Computer and mobile services',
                    'children' => []
                ],
                [
                    'name' => 'مالی/حسابداری/بیمه',
                    'name_en' => 'Finance/Accounting/Insurance',
                    'children' => []
                ],
                [
                    'name' => 'حمل و نقل',
                    'name_en' => 'Transportation',
                    'children' => []
                ],
                [
                    'name' => 'پیشه و مهارت',
                    'name_en' => 'Profession and skill',
                    'children' => []
                ],
                [
                    'name' => 'آرایشگری و زیبایی',
                    'name_en' => 'Hairdressing and beauty',
                    'children' => []
                ],
                [
                    'name' => 'سرگرمی',
                    'name_en' => 'entertainment',
                    'children' => []
                ],
                [
                    'name' => 'نظافت',
                    'name_en' => 'cleaning',
                    'children' => []
                ],
                [
                    'name' => 'باغبانی و درختکاری',
                    'name_en' => 'Gardening and arboriculture',
                    'children' => []
                ],
                [
                    'name' => 'آموزشی',
                    'name_en' => 'educational',
                    'children' => []
                ],
            ],
            "personal-stuff" => [
                [
                    'name' => 'کیف، کفش و لباس',
                    'name_en' => 'Bags, shoes and clothes',
                    'children' => [
                        'Bag/shoes/belt' => 'کیف/کفش/کمربند',
                        'Dress' => 'لباس',
                    ]
                ],
                [
                    'name' => 'زیورآلات و اکسسوری',
                    'name_en' => 'Jewelry and accessories',
                    'children' => [
                        'the watch' => 'ساعت',
                        'Jewellery' => 'جواهرات',
                        'rhinestones' => 'بدلیجات',
                    ]
                ],
                [
                    'name' => 'آرایشی، بهداشتی و درمانی',
                    'name_en' => 'Cosmetics, health and therapy',
                    'children' => [

                    ]
                ],
                [
                    'name' => 'کفش و لباس بچه',
                    'name_en' => "Children's shoes and clothes",
                    'children' => []
                ],
                [
                    'name' => 'وسایل بچه و اسباب بازی',
                    'name_en' => "Children's equipment and toys",
                    'children' => [
                        "toy" => "اسباب بازی",
                        "Strollers and accessories" => "کالسکه و لوازم جانبی",
                        "kid's chair" => "صندلی بچه",
                        "Baby furniture" => "اسباب و اثاث بچه",
                    ]
                ],
                [
                    'name' => 'لوازم التحریر',
                    'name_en' => 'Stationery',
                    'children' => []
                ],
            ],
            "entertainment-and-leisure" => [
                [
                    'name' => 'بلیط',
                    'name_en' => 'Ticket',
                    'children' => [
                        "Concert" => "کنسرت",
                        "Theater and cinema" => "تئاتر و سینما",
                        "Gift card and discount" => "کارت هدیه و تخفیف",
                        "Sports venues and competitions" => "اماکن و مسابقات ورزشی",
                        "sports" => "ورزشی",
                        "Bus, subway and train" => "اتوبوس، مترو و قطار",
                    ]
                ],
                [
                    'name' => 'تور و چارتر',
                    'name_en' => 'Tour and charter',
                    'children' => []
                ],
                [
                    'name' => 'کتاب و مجله',
                    'name_en' => 'book and magazine',
                    'children' => [
                        "educational" => "آموزشی",
                        "Literary" => "ادبی",
                        "historical" => "تاریخی",
                        "Religious" => "مذهبی",
                        "magazines" => "مجلات",
                    ]
                ],
                [
                    'name' => 'دوچرخه/اسکیت/اسکوتر',
                    'name_en' => 'Bicycle/skate/scooter',
                    'children' => []
                ],
                [
                    'name' => 'حیوانات',
                    'name_en' => 'Animals',
                    'children' => [
                        "Cat" => "گربه",
                        "mouse and rabbit" => "موش و خرگوش",
                        "Creepy" => "خزنده",
                        "Bird" => "پرنده",
                        "Fish" => "ماهی",
                        "accessories" => "لوازم جانبی",
                        "farm animals" => "حیوانات مزرعه",
                        "Dog" => "سگ",
                    ]
                ],
                [
                    'name' => 'کلکسیون و سرگرمی',
                    'name_en' => 'Collection and entertainment',
                    'children' => [
                        "Coins, stamps and bills" => "سکه، تمبر و اسکناس",
                        "Antique objects" => "اشیای عتیقه",
                    ]
                ],
                [
                    'name' => 'آلات موسیقی',
                    'name_en' => 'Musical Instruments',
                    'children' => [
                        "Guitar, bass and amplifier" => "گیتار، بیس و امپلیفایر",
                        "wind instruments" => "سازهای بادی",
                        "Piano/keyboard/accordion" => "پیانو/کیبورد/آکاردئون",
                        "Traditional" => "سنتی",
                        "Drum and percussion" => "درام و پرکاشن",
                        "Violin" => "ویولن",
                    ]
                ],
                [
                    'name' => 'ورزش و تناسب اندام',
                    'name_en' => 'Exercise and fitness',
                    'children' => [
                        "Ball sports" => "ورزش‌های توپی",
                        "Mountaineering and camping" => "کوهنوردی و کمپینگ",
                        "Diving and water sports" => "غواصی و ورزش‌های آبی",
                        "Fishing" => "ماهیگیری",
                        "Sports equipment" => "تجهیزات ورزشی",
                        "winter sports" => "ورزش‌های زمستانی",
                        "Horses and equestrian equipment" => "اسب و تجهیزات اسب سواری",
                    ]
                ],
                [
                    'name' => 'اسباب‌ بازی',
                    'name_en' => 'Toy',
                    'children' => []
                ],
            ],
            "social" => [
                [
                    'name' => 'رویداد',
                    'name_en' => 'Event',
                    'children' => [
                        "on sale" => "حراج",
                        "Meeting and conference" => "گردهمایی و همایش",
                        "sports" => "ورزشی",
                    ]
                ],
                [
                    'name' => 'داوطلبانه',
                    'name_en' => 'Voluntarily',
                    'children' => [
                        "research" => "تحقیقاتی"
                    ]
                ],
                [
                    'name' => 'گم‌شده‌ها',
                    'name_en' => 'losts',
                    'children' => [
                        "Animals" => "حیوانات",
                        "things" => "اشیا",
                    ]
                ],
            ],
            "equipment-and-machinery" => [
                [
                    'name' => 'مصالح و تجهیزات ساختمان',
                    'name_en' => 'Building materials and equipment',
                    'children' => []
                ],
                [
                    'name' => 'ابزارآلات',
                    'name_en' => 'Tools',
                    'children' => []
                ],
                [
                    'name' => 'ماشین‌آلات صنعتی',
                    'name_en' => 'Industrial Machinery',
                    'children' => []
                ],
                [
                    'name' => 'تجهیزات کسب‌وکار',
                    'name_en' => 'Business equipment',
                    'children' => [
                        "medical" => "پزشکی",
                        "Stores and shops" => "فروشگاه و مغازه",
                        "Coffee shop and restaurant" => "کافی‌شاپ و رستوران",
                        "Hairdressers and beauty salons" => "آرایشگاه و سالن های زیبایی",
                        "office" => "دفتر کار",
                    ]
                ],
                [
                    'name' => 'عمده فروشی',
                    'name_en' => 'Wholesale',
                    'children' => []
                ],
            ],
        ];

        DB::beginTransaction();

        foreach($cats as $parentKey => $parentVal){
            $parentCategory = Category::whereSlug($parentKey)->first();
            if($parentCategory){
                foreach($parentVal as $key => $subparent){
                    $subCat = Category::firstOrCreate(
                        [
                            'slug' => Str::slug($subparent['name_en'])
                        ],
                        [
                            'name' => $subparent['name'],
                            'name_en' => $subparent['name_en'],
                            'is_visible' => 1,
                            'position' => $key,
                            'parent_id' => $parentCategory->id
                        ]
                    );
                    foreach($subparent['children'] as $nameEn => $nameFa){
                        Category::updateOrCreate(
                            [
                                'slug' => Str::slug($nameEn),
                            ],
                            [
                                'name' => $nameFa,
                                'name_en' => $nameEn,
                                'is_visible' => 1,
                                'position' => 0,
                                'parent_id' => $subCat->id
                            ]
                        );
                    }
                }
            }else{
                dump($parentKey);
            }
        }

        DB::commit();
    }
}
