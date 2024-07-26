<?php

namespace App\Console\Commands;

use App\Models\Ad\Ad;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Telegram;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

class PinAdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:pin';

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
        $t = new Api(st()->botApiToken);
        $u = $t->getWebhookUpdate();
        $m = $u->getMessage();

        $ad = Ad::where('slug', 'mediatel')->first();
        // $ad = Ad::where('slug', 'iranian-building-painting')->first();

        // $ad->getFirstMediaUrl('SpecialImage');

        $text = "
<b>$ad->title</b>
<i>$ad->content_strip</i>
<a href=\"" .route('front.ad.show', $ad->slug) ."\">لینک آگهی</a>
        ";

        // dd();
        // dd($ad->getFirstMedia('SpecialImage')->getPath());
        // $path = public_path(Str::after($ad->getFirstMediaUrl('SpecialImage'), env('APP_URL')));
        // dd($path);
        // dd(InputFile::create($ad->getFirstMedia('SpecialImage')->getPath(), $ad->slug));
        $path = str_replace('\\', '/', $ad->getFirstMedia('SpecialImage')->getPath());
        // $r = $t->sendMessage([
        //     'chat_id' => '@myadvertisingchannel',
        //     'text' => 'This is a message sent from my bot to a channel!'
        // ]);
        $r = $t->sendPhoto([
            'chat_id' => '@myadvertisingchannel',
            'photo' => InputFile::create($path, $ad->slug),
            'caption' => $text,
            'parse_mode' => 'HTML'
        ]);

        $t->pinChatMessage([
            'chat_id' => '@myadvertisingchannel',
            'message_id' => $r->messageId
        ]);

        $t->sendMessage([
            'chat_id' => '118832250',
            'text' => 'This is a message sent from my bot to a user!'
        ]);
    }
}
