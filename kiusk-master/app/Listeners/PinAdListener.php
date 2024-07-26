<?php

namespace App\Listeners;

use App\Events\PinAdEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

class PinAdListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PinAdEvent  $event
     * @return void
     */
    public function handle(PinAdEvent $event)
    {
        if(env('APP_ENV') !== 'local'){
            $t = new Api(st()->botApiToken);
            $u = $t->getWebhookUpdate();
            $m = $u->getMessage();

            $ad = $event->ad;

            $text = "
<b>$ad->title</b>

🔰 $ad->content_strip

🔗<a href=\"" .route('front.ad.show', $ad->slug) ."\">لینک آگهی</a>

". st()->telegramChannel ."
            ";

            if($ad->getFirstMediaUrl('SpecialImage')){
                $path = str_replace('\\', '/', $ad->getFirstMedia('SpecialImage')->getPath());
                $r = $t->sendPhoto([
                    'chat_id' => st()->telegramChannel,
                    'photo' => InputFile::create($path, $ad->slug),
                    'caption' => $text,
                    'parse_mode' => 'HTML'
                ]);
            }else{
                $r = $t->sendMessage([
                    'chat_id' => st()->telegramChannel,
                    'text' => $text,
                    'parse_mode' => 'HTML'
                ]);
            }

            $t->pinChatMessage([
                'chat_id' => st()->telegramChannel,
                'message_id' => $r->messageId
            ]);

            $ad->update(['telegram_message_id' => $r->messageId]);
        }else{
            Log::info('PinAdListener Ran');
        }
    }
}
