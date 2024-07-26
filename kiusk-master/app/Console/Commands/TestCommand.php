<?php

namespace App\Console\Commands;

use App\Models\Ad\Ad;
use App\Models\TelegramAd;
use App\Models\User;
use App\Traits\TelegramTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use stdClass;
use Illuminate\Support\Str;
use Telegram\Bot\Api;

class TestCommand extends Command
{
    use TelegramTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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

    public function updateUserExtra($function): void
    {
        $user = User::where('email', 'baranartsgallery@gmail.com')->first();
        $x = $user->extra ?? new stdClass();
        $x = $function($x);
        $user->update(['extra' => $x,]);
    }

    public function errorMessage(string $message): void
    {
        $this->updateUserExtra(function ($x) use ($message) {
            $x->errorMessage = '' . $message . '';

            return $x;
        });
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find(1);
        $x = $user->extra;
        dump($x);
        unset($x->adsCreate);
        $user->update(['extra' => $x]);
        dd($user->extra);

        // $user = User::where('email', 'baranartsgallery@gmail.com')->first();
        // $this->errorMessage('🚫' . __("messages.unknown_error_message") . '🚫');
        // return $this->sendMessage($user->telegram_id, '🚫' . __("messages.unknown_error_message") . '🚫');
        // return $this->sendMessage($user->telegram_id, "this is a test message");
        // $content = "فروش موبايل فروش موبايل موبايل فروش موبايل فروش موبايل �";

        // dd(str_split($content, 160)[0]);
        // try {
        //     DB::beginTransaction();
        //     $ad = Ad::create([
        //         'title' => "فروش خانه",
        //         'title_en' => "فروش خانه",
        //         'slug' => "sell_house2",
        //         // 'slug' => \Str::slug($adcreate->title_en ?? $adcreate->title),
        //         'content' => $content,
        //         'content_en' => $content,
        //         'is_featured' => 0,
        //         'price' => null,
        //         'is_visible' => false,
        //         'user_id' => 1,
        //         'seo_title' => str_split("فروش خانه", 60)[0],
        //         'seo_description' => str_split($content, 160)[0],
        //         'state_id' => 1,
        //         'city_id' => null,
        //     ]);
        //     // DB::commit();
        // } catch (\Exception $e) {
        //     dd($e);
        // }
        dd('done');
        // $type = 'vip';
        // $ad = TelegramAd::create([
        //     'ad_type' => $type,
        //     'link' => 'https://kiusk.ca/',
        //     'description' => 'لاین ۱
        //     لاین ۲
        //     لاین۳',
        //     'description_en' => 'English content
        //     line 2
        //     line 3',
        //     'is_approved' => true,
        //     'user_id' => 1,
        // ]);
        // $ad->addMediaFromUrl('https://kiusk.ca/images/kiusk-placeholder.jpg')->toMediaCollection('SpecialImage');
        $ad = TelegramAd::query();
        $langIsFa = true;

        if ($type) {
            $ad = $ad->where('ad_type', $type);
        }
        $ad = $ad->inRandomOrder()->isApproved()->isPaid()->first();
        if ($ad) {
            $image = $langIsFa ? 'SpecialImage' : 'SpecialImageEn';
            $adButton = __("Display Ad");
            $link = '
<a href="' . $ad->link . '">' . $adButton . '</a>';
            $caption = $ad->description . $link;

            if ($ad->getFirstMediaUrl($image)) {
                $path = str_replace('\\', '/', $ad->getFirstMedia($image)->getPath());
                $ad->increment('views');
                dd($ad);
                // $r = $t->sendPhoto([
                //     'chat_id' => $u->getChat()->id,
                //     'photo' => InputFile::create($path, $ad->id),
                //     'caption' => $caption,
                //     'parse_mode' => 'HTML'
                // ]);
                // return $r;
            }
        }
        return null;
        // $userId = 123456;
        // $length = strlen($userId) >= 15 ?: 15 - strlen($userId);
        // $randomString = Str::random($length);
        // $referralCode = 'KS' . substr_replace($randomString, $userId, rand(0, strlen($randomString)), 0);
        // dump($referralCode);
        // $x = new stdClass;
        // $ad = Ad::find(729);
        // $x->adsEdit = $ad;
        // $facilities = $ad->facilities()?->where('type', 'facility')->pluck('id')->toArray() ?? [];
        // $x->adsEdit->facilities = $facilities;
        // $facilityId = 4;
        // if(!isset($x->adsEdit->facilities)){
        //     $x->adsEdit->facilities = [];
        // }
        // if (!in_array($facilityId, $x->adsEdit->facilities)) {
        //     $x->adsEdit->facilities[] = $facilityId;
        // } else {
        //     $key = array_search($facilityId, $x->adsEdit->facilities);
        //     unset($x->adsEdit->facilities[$key]);
        // }
        // return $x;
    }
}
