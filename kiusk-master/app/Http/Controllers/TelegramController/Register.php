<?php

namespace App\Http\Controllers\TelegramController;

use App\Events\RegisterEvent;
use App\Models\User;
use Illuminate\Support\Collection;
use stdClass;
use Str;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Register
{
    public function register(Api $t, Update $u): void
    {
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
        $r = $t->sendMessage([
                              'chat_id' => $u->getChat()->id,
                              'message_id' => $this->getLastMessageId(),
                              'text' => $text,
                              'reply_markup' => $keyboard,
                             ]);
        $this->updateLastMessage($text);
        $field = 'registerMessageId';
        $value = $r->messageId;
        $user = auth()->user();
        $x = $user->extra ?? new stdClass();
        $x->{$field} = $value;
        $user->update(['extra' => $x,]);
    }

    public function registerStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $list = [
         '1',
         '98',
        ];
        $s = Str::of($m->contact->phoneNumber);
        $phone = '';
        $code = '';
        foreach ($list as $c) {
            if (str_contains($s, '+')) {
                if ($s->is('+' . $c . '*')) {
                    $phone = (string)Str::after($s, $c);
                    $code = '+' . $c;
                }
            } else {
                if ($s->is($c . '*')) {
                    $phone = (string)Str::after($s, $c);
                    $code = '+' . $c;
                }
            }
        }
        // if(!in_array($code, $list)){
        //     $buttons1 = Keyboard::button([
        //         'text' => st()->registerKeyboard[1]['keyName'],
        //        ]);
        //     $keyboard = Keyboard::make()
        //         ->row($buttons1);
        //     // $this->errorMessage(st()->registerPhoneError);
        //    $this->deleteLastMessage($t, $u);
        //     return $t->sendMessage([
        //         'chat_id' => $u->getChat()->id,
        //         'text' => st()->registerPhoneError,
        //         'reply_markup' => $keyboard,
        //     ]);
        // }
        $user = User::wherePhone($phone)
                    ->whereCountryCode($code)
                    ->first();
        $auth2 = auth()->user();
        if ($user && ! $user->telegram_id) {
            $auth = new User($auth2->toArray());
            ;
            if ($auth2->delete()) {
                $user->name ?: $user->name = $auth->name;
                $user->first_name ?: $user->first_name = $auth->first_name;
                $user->last_name ?: $user->last_name = $auth->last_name;
                $user->country_code = $code;
                $user->phone = $phone;
                $user->birthday ?: $user->birthday = $auth->birthday;
                $user->address ?: $user->address = $auth->address;
                $user->description ?: $user->description = $auth->description;
                $user->rule ?: $user->rule = $auth->rule;
                $user->email ?: $user->email = $auth->email;
                $user->phone_verified_at ?: $user->phone_verified_at = $auth->phone_verified_at;
                $user->password ?: $user->password = $auth->password;
                $user->telegram_id ?: $user->telegram_id = $auth->telegram_id;
                $user->telegram_first_name ?: $user->telegram_first_name = $auth->telegram_first_name;
                $user->telegram_last_name ?: $user->telegram_last_name = $auth->telegram_last_name;
                $user->telegram_username ?: $user->telegram_username = $auth->telegram_username;
                //   $user->telegram_last_message ?: $user->telegram_last_message = $auth->telegram_last_message;
                $user->telegram_last_message_id ?: $user->telegram_last_message_id = $auth->telegram_last_message_id;
                $user->extra ?: $user->extra = $auth->extra;
                $user->save();
            }
        } else {
            auth()
             ->user()
             ->update([
                       'phone' => $phone,
                       'country_code' => $code,
                       'phone_verified_at' => now()
                      ]);
        }
        //پیام ربات
        $registerMessageId = auth()->user()->extra?->registerMessageId;
        if ($registerMessageId) {
            $t->deleteMessage([
                               'chat_id' => $u->getChat()->id,
                               'message_id' => $registerMessageId,
                              ]);
        }
        //شماره تلفن
        $t->deleteMessage([
                           'chat_id' => $u->getChat()->id,
                           'message_id' => $m->messageId,
                          ]);
        if(auth()?->user() && !auth()->user()->subscription){
            RegisterEvent::dispatch(auth()->user());
        }
        $this->updateLastMessage();
        $this->successMessage(st()->registerSuccess);
        $this->startBack($t, $u);
    }

    public function checkPhoneCountryCode(Str $phoneNumber)
    {
        return $phoneNumber->is('+' . '1' . '*');
    }
}
