<?php

namespace App\Models;

use App\Models\Lib\ClearsResponseCache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Plan extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use ClearsResponseCache;

    protected $fillable = [
        'name_fa', 'name_en', 'slug', 'price', 'currency', 'description', 'description_en', 'is_active',
        'email_notification', 'sms_notification', 'invoice_period', 'invoice_interval', 'type',
        'limit', 'featured_limit', 'show_in_sidebar', 'show_in_suggestion', 'show_in_main_page',
        'vip', 'discount_price', 'best_offer', 'pin_ad', 'motion_story', 'story', 'free_blog_ad',
        'telegram_group_ad', 'telegram_channel', 'tax', 'narration', 'position', 'model_type', 'telegram_bot'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_notification' => 'boolean',
        'sms_notification' => 'boolean',
        'show_in_sidebar' => 'boolean',
        'show_in_suggestion' => 'boolean',
        'show_in_main_page' => 'boolean',
        'telegram_bot' => 'boolean',
        'vip' => 'boolean',
        'price' => 'integer'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['locale_description'];

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const INTERVALS = [
        'day' => 'روز',
        'month' => 'ماه',
        'year' => 'سال',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const INTERVALS_DAYS = [
        'day' => 1,
        'month' => 30,
        'year' => 365,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const LANGS = [
        'fa' => 'فارسی',
        'en' => 'انگلیسی',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const TYPES = [
        'free' => 'رایگان',
        'premium' => 'پریمیوم',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const MODEL_TYPES = [
        'upgrade_level' => 'ارتقا سطح کاربری',
        'ad' => 'آگهی سایت',
        'advertisement' => 'آگهی تبلیغ سایت',
        'telegramAd' => 'آگهی تبلیغ تلگرام',
        'pinAd' => 'پین در کانال تلگرام',
    ];

    /**
     * Get the category's locale name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return (auth()?->user()?->lang == 'fa' || config('app.locale') == 'fa') ? $this->name_fa : ucfirst($this->name_en);
    }

    /**
     * Get the category's locale description.
     *
     * @return string
     */
    public function getLocaleDescriptionAttribute()
    {
        return config('app.locale') == 'fa' ? $this->description : $this->description_en;
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const CURRENCIES = [
        "AED" => "UAE dirham",
        "AFN" => "Afghan afghani",
        "ALL" => "Albanian lek",
        "AMD" => "Armenian dram",
        "ANG" => "Netherlands Antillean gulden",
        "AOA" => "Angolan kwanza",
        "ARS" => "Argentine peso",
        "AUD" => "Australian dollar",
        "AWG" => "Aruban florin",
        "AZN" => "Azerbaijani manat",
        "BAM" => "Bosnia and Herzegovina konvertibilna marka",
        "BBD" => "Barbadian dollar",
        "BDT" => "Bangladeshi taka",
        "BGN" => "Bulgarian lev",
        "BHD" => "Bahraini dinar",
        "BIF" => "Burundi franc",
        "BMD" => "Bermudian dollar",
        "BND" => "Brunei dollar",
        "BOB" => "Bolivian boliviano",
        "BRL" => "Brazilian real",
        "BSD" => "Bahamian dollar",
        "BTN" => "Bhutanese ngultrum",
        "BWP" => "Botswana pula",
        "BYR" => "Belarusian ruble",
        "BZD" => "Belize dollar",
        "CAD" => "Canadian dollar",
        "CDF" => "Congolese franc",
        "CHF" => "Swiss franc",
        "CLP" => "Chilean peso",
        "CNY" => "Chinese/Yuan renminbi",
        "COP" => "Colombian peso",
        "CRC" => "Costa Rican colon",
        "CUC" => "Cuban peso",
        "CVE" => "Cape Verdean escudo",
        "CZK" => "Czech koruna",
        "DJF" => "Djiboutian franc",
        "DKK" => "Danish krone",
        "DOP" => "Dominican peso",
        "DZD" => "Algerian dinar",
        "EEK" => "Estonian kroon",
        "EGP" => "Egyptian pound",
        "ERN" => "Eritrean nakfa",
        "ETB" => "Ethiopian birr",
        "EUR" => "European Euro",
        "FJD" => "Fijian dollar",
        "FKP" => "Falkland Islands pound",
        "GBP" => "British pound",
        "GEL" => "Georgian lari",
        "GHS" => "Ghanaian cedi",
        "GIP" => "Gibraltar pound",
        "GMD" => "Gambian dalasi",
        "GNF" => "Guinean franc",
        "GQE" => "Central African CFA franc",
        "GTQ" => "Guatemalan quetzal",
        "GYD" => "Guyanese dollar",
        "HKD" => "Hong Kong dollar",
        "HNL" => "Honduran lempira",
        "HRK" => "Croatian kuna",
        "HTG" => "Haitian gourde",
        "HUF" => "Hungarian forint",
        "IDR" => "Indonesian rupiah",
        "ILS" => "Israeli new sheqel",
        "INR" => "Indian rupee",
        "IQD" => "Iraqi dinar",
        "IRR" => "Iranian rial",
        "ISK" => "Icelandic kr\u00f3na",
        "JMD" => "Jamaican dollar",
        "JOD" => "Jordanian dinar",
        "JPY" => "Japanese yen",
        "KES" => "Kenyan shilling",
        "KGS" => "Kyrgyzstani som",
        "KHR" => "Cambodian riel",
        "KMF" => "Comorian franc",
        "KPW" => "North Korean won",
        "KRW" => "South Korean won",
        "KWD" => "Kuwaiti dinar",
        "KYD" => "Cayman Islands dollar",
        "KZT" => "Kazakhstani tenge",
        "LAK" => "Lao kip",
        "LBP" => "Lebanese lira",
        "LKR" => "Sri Lankan rupee",
        "LRD" => "Liberian dollar",
        "LSL" => "Lesotho loti",
        "LTL" => "Lithuanian litas",
        "LVL" => "Latvian lats",
        "LYD" => "Libyan dinar",
        "MAD" => "Moroccan dirham",
        "MDL" => "Moldovan leu",
        "MGA" => "Malagasy ariary",
        "MKD" => "Macedonian denar",
        "MMK" => "Myanma kyat",
        "MNT" => "Mongolian tugrik",
        "MOP" => "Macanese pataca",
        "MRO" => "Mauritanian ouguiya",
        "MUR" => "Mauritian rupee",
        "MVR" => "Maldivian rufiyaa",
        "MWK" => "Malawian kwacha",
        "MXN" => "Mexican peso",
        "MYR" => "Malaysian ringgit",
        "MZM" => "Mozambican metical",
        "NAD" => "Namibian dollar",
        "NGN" => "Nigerian naira",
        "NIO" => "Nicaraguan c\u00f3rdoba",
        "NOK" => "Norwegian krone",
        "NPR" => "Nepalese rupee",
        "NZD" => "New Zealand dollar",
        "OMR" => "Omani rial",
        "PAB" => "Panamanian balboa",
        "PEN" => "Peruvian nuevo sol",
        "PGK" => "Papua New Guinean kina",
        "PHP" => "Philippine peso",
        "PKR" => "Pakistani rupee",
        "PLN" => "Polish zloty",
        "PYG" => "Paraguayan guarani",
        "QAR" => "Qatari riyal",
        "RON" => "Romanian leu",
        "RSD" => "Serbian dinar",
        "RUB" => "Russian ruble",
        "SAR" => "Saudi riyal",
        "SBD" => "Solomon Islands dollar",
        "SCR" => "Seychellois rupee",
        "SDG" => "Sudanese pound",
        "SEK" => "Swedish krona",
        "SGD" => "Singapore dollar",
        "SHP" => "Saint Helena pound",
        "SLL" => "Sierra Leonean leone",
        "SOS" => "Somali shilling",
        "SRD" => "Surinamese dollar",
        "SYP" => "Syrian pound",
        "SZL" => "Swazi lilangeni",
        "THB" => "Thai baht",
        "TJS" => "Tajikistani somoni",
        "TMT" => "Turkmen manat",
        "TND" => "Tunisian dinar",
        "TRY" => "Turkish new lira",
        "TTD" => "Trinidad and Tobago dollar",
        "TWD" => "New Taiwan dollar",
        "TZS" => "Tanzanian shilling",
        "UAH" => "Ukrainian hryvnia",
        "UGX" => "Ugandan shilling",
        "USD" => "United States dollar",
        "UYU" => "Uruguayan peso",
        "UZS" => "Uzbekistani som",
        "VEB" => "Venezuelan bolivar",
        "VND" => "Vietnamese dong",
        "VUV" => "Vanuatu vatu",
        "WST" => "Samoan tala",
        "XAF" => "Central African CFA franc",
        "XCD" => "East Caribbean dollar",
        "XDR" => "Special Drawing Rights",
        "XOF" => "West African CFA franc",
        "XPF" => "CFP franc",
        "YER" => "Yemeni rial",
        "ZAR" => "South African rand",
        "ZMK" => "Zambian kwacha",
        "ZWR" => "Zimbabwean dollar",
    ];

    /**
     * is active scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeIsActive($query)
    {
        $query->where('is_active', 1);
    }

    /**
     * Returns user plan invoice period in days
     *
     * @return integer
     */
    public function convertDays() : int
    {
        return $this->invoice_period * self::INTERVALS_DAYS[$this->invoice_interval];
    }
}
