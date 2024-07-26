<?php

namespace App\Http\Controllers\TelegramController\v2\Register;

use App\Events\RegisterEvent;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait BusinussOwner
{
    public function registerBusinessOwner(Api $t, Update $u): void
    {
        $this->sharePhoneForBusinessOwner($t, $u);
    }

    public function registerBusinessOwnerGuide(Api $t, Update $u): void
    {
        // $text = "BusinessOwner User Guide Text";
        $text = st()->registerBusinessOwnerUserGuideText;
        $this->sendMessageText($t, $u, $text);
    }

    public function sharePhoneForBusinessOwner(Api $t, Update $u)
    {
        $this->deleteLastRequest($t, $u);
        $buttons = Keyboard::button([
            'text' => st()->registerKeyboard[0]['keyName'],
            'request_contact' => true,
        ]);
        $buttons1 = Keyboard::button([
            'text' => st()->registerKeyboard[1]['keyName'],
        ]);
        $keyboard = Keyboard::make()
            ->row($buttons)
            ->row($buttons1);
        $text = st()->registerText;
        // "کاربرگرامی\nبرای اینکه بتوانید از خدمات رایگان ربات کیوسک استفاده کنید\nشماره تلفن شما باید شماره کانادا🇨🇦 باشد ، تا اگهی های شما در ربات ثبت و در سایر مدیاهای کیوسک منتشر شود\n\nلطفا شماره تلفن خود را با استفاده از دکمه زیر ارسال کنید.👇"
        // "Dear User\nIn order to be able to use the free services of the Kiusk Robot\n, your phone number must be a Canadian number 🇨🇦, so that your ads can be registered in the robot and published in other Kiusk media\n\nPlease enter your phone number using the button below.👇"
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
        // $this->updateLastMessage($text);
        $this->updateLastRequestId($r->messageId);
        $field = 'registerMessageId';
        $value = $r->messageId;
        $user = auth()->user();
        $x = $user->extra ?? new stdClass();
        $x->{$field} = $value;
        $user->update(['extra' => $x, 'telegram_last_method' => 'sharePhoneForBusinessOwner']);
    }

    public function storeBusinessOwner(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->setLanguage();
        $this->registerUser($t, $u, $m, 'business_owner');
    }
}
