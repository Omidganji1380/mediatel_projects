<?php

namespace App\Http\Controllers\TelegramController\v2;

use App\Models\TelegramAd;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;

trait Start
{
    //start
    public function start(Api $t, Update $u)
    {
        $this->setLanguage();
        $this->reset();

        $user = auth()->user();

        $this->getAd($t, $u, $user->getRoleNames()?->first());

        $filePath = public_path('images/start.jpg');
        $fileExists = File::exists($filePath);

        if ($fileExists) {
            // The file exists in the directory
            $t->sendPhoto([
                'chat_id' => $u->getChat()->id,
                'photo' => InputFile::create(public_path('/' . "images/start.jpg"), 'welcome.png'),
            ]);
        }

        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => st()->startText,
            'reply_markup' => $this->startKeyboard(),
        ]);
        // $this->updateLastMessageId($response->messageId);
        // $this->updateLastRequestId($response->messageId);
        return $response;
    }

    public function startRemoveKeyboard(Api $t, Update $u): void
    {
        $this->setLanguage();
        $user = auth()->user();
        $this->getAd($t, $u, $user->getRoleNames()?->first());
        $this->deleteLastRequest($t, $u);
        $text = $this->flashMassage() ?: st()->startText;
        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => $text,
            'reply_markup' => $this->startKeyboard(),
        ]);
        $this->updateLastMessageId($response->messageId);
    }

    public function startBack(Api $t, Update $u): void
    {
        $this->setLanguage();
        $user = auth()->user();
        $this->getAd($t, $u, $user->getRoleNames()?->first());
        $text = $this->flashMassage() ?: st()->startText;
        $response = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->startKeyboard(),
        ]);
    }

    public function startKeyboard(): Keyboard
    {
        $inlineButton = Keyboard::button([
            'text' => __('Create Ad') . ' ➕',
        ]);
        $inlineButton1 = Keyboard::button([
            'text' => __('Register') . ' ®️',
        ]);
        $inlineButton2 = Keyboard::button([
            'text' => __('My Ads') . ' 📜',
        ]);
        $inlineButton3 = Keyboard::button([
            'text' => __('My profile') . ' 👤',
        ]);
        $inlineButton4 = Keyboard::button([
            'text' => __('Pin Ad') . ' 📌',
        ]);
        $inlineButton5 = Keyboard::button([
            'text' => __('Language') . ' 🌐',
        ]);
        $inlineButton6 = Keyboard::button([
            'text' => __('Help') . ' 👥',
        ]);
        $inlineButton7 = Keyboard::button([
            'text' => __('Extensive advertising in Canada') . ' 🇨🇦',
        ]);
        $keyboard = Keyboard::make()
            ->row($inlineButton, $inlineButton1)
            ->row($inlineButton2, $inlineButton3)
            ->row($inlineButton4, $inlineButton5)
            ->row($inlineButton6)
            ->row($inlineButton7);

        return $keyboard;
    }

    public function oldStartKeyboard(): Keyboard
    {
        $inlineButton = Keyboard::inlineButton([
            'text' => st()->startKeyboard[0]['keyName']  . ' 📣',
            'callback_data' => 'adsCreate',
        ]);
        $inlineButton1 = Keyboard::inlineButton([
            'text' => (auth()->user()->phone ? '✅' : '❌') . st()->startKeyboard[1]['keyName'] . ' 👨‍💻',
            'callback_data' => 'register',
        ]);
        $inlineButton2 = Keyboard::inlineButton([
            'text' => st()->startKeyboard[2]['keyName'] . ' 📂',
            'callback_data' => 'adsList',
        ]);
        $inlineButton3 = Keyboard::inlineButton([
            'text' => st()->startKeyboard[3]['keyName'] . ' 👤',
            'callback_data' => 'profile',
        ]);
        $inlineButton4 = Keyboard::inlineButton([
            'text' => st()->startKeyboard[4]['keyName'] . ' 🌐',
            'callback_data' => 'language',
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($inlineButton, $inlineButton1)
            ->row($inlineButton2, $inlineButton3)
            ->row($inlineButton4);

        return $keyboard;
    }

    public function startText()
    {
        $current_time = Carbon::now();

        if ($current_time->hour < 12) {
            return st()->startTextMorning;
        } elseif ($current_time->hour < 18) {
            return st()->startTextAfternoon;
        } else {
            return st()->startTextEvening;
        }
    }

    public function getAd($t, $u, $type = null)
    {
        if($type){
            $ad = TelegramAd::query();
            $langIsFa = auth()?->user()?->isLangFa();
            $ad = $ad->where('ad_type', $type);
            $ad = $ad->inRandomOrder()->isApproved()->isPaid()->first();
            if($ad){
                $image = $langIsFa ? 'SpecialImage' : 'SpecialImageEn';
                $adButton = __("Display Ad");
                $link = '
<a href="' . $ad->link . '">' . $adButton . '</a>';
                $caption = $ad->description . $link;

                if($ad->getFirstMediaUrl($image)){
                    $path = str_replace('\\', '/', $ad->getFirstMedia($image)->getPath());
                    $ad->increment('views');
                    $r = $t->sendPhoto([
                        'chat_id' => $u->getChat()->id,
                        'photo' => InputFile::create($path, $ad->id),
                        'caption' => $caption,
                        'parse_mode' => 'HTML'
                    ]);
                    return $r;
                }
            }
        }
        return null;
    }
}
