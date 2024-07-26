<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Settings\TelegramEnSettings;
use App\Settings\TelegramSettings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelSettings\Settings;

class kiuskDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:settings';

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
        $setting = new TelegramSettings();
        // $setting->botApiToken = '6497087801:AAHiq-cQPrbQASjmGLAqud_G3pLqFKDc8cE';
        $setting->mainPageAdPlaceholder = "setting/yLtSxY7RSb6dGAhDjszyp12EmWUn62-metaYWRzLW1haW4tZmEuanBn-.jpg";
        $setting->mainPageAdPlaceholder2 = "setting/oQrCjVqWvc04nzPvMc6xB6bUyrIylw-metaYWRzLW1haW4tZmEtMi5qcGc=-.jpg";
        $setting->PAYPAL_CLIENT_ID = "AbBbwm2h8jQm-jTaG68Hg7w93f2Fy7a-a4gGJ8LPWs6AvY5-RFUCVzPVGcp--lq6lAPqCsSjRX4Q1kxE";
        $setting->PAYPAL_SECRET = "EPmna103iSr2jTNM90USV1cQIQgc057MDd3N797TK8m2sY8ZOfDW6xBwlnh2SEnEOFBwH_nooPMbIMKg";
        $setting->save();
        $setting = new TelegramEnSettings();
        // $setting->botApiToken = '6497087801:AAHiq-cQPrbQASjmGLAqud_G3pLqFKDc8cE';
        $setting->mainPageAdPlaceholder = "setting/dEzzM4YY8UajvFIjgOpsXNtuNjiJH4-metaYWRzLW1haW4tZW4uanBn-.jpg";
        $setting->mainPageAdPlaceholder2 = "setting/uC2lrecs8NKWKRp8hf1WYT2Uhigy5b-metaYWRzLW1haW4tZW4tMi5qcGc=-.jpg";
        $setting->PAYPAL_CLIENT_ID = "AbBbwm2h8jQm-jTaG68Hg7w93f2Fy7a-a4gGJ8LPWs6AvY5-RFUCVzPVGcp--lq6lAPqCsSjRX4Q1kxE";
        $setting->PAYPAL_SECRET = "EPmna103iSr2jTNM90USV1cQIQgc057MDd3N797TK8m2sY8ZOfDW6xBwlnh2SEnEOFBwH_nooPMbIMKg";
        $setting->save();
        dump('settings Updated');
    }
}
