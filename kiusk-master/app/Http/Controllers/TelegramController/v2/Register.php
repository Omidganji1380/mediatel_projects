<?php

namespace App\Http\Controllers\TelegramController\v2;

use App\Events\RegisterEvent;
use App\Http\Controllers\TelegramController\v2\Register\BusinussOwner;
use App\Http\Controllers\TelegramController\v2\Register\NormalUser;
use App\Http\Controllers\TelegramController\v2\Register\PropertyApplicant;
use App\Http\Controllers\TelegramController\v2\Register\RealEstate;
use App\Http\Controllers\TelegramController\v2\Register\Seller;
use App\Http\Controllers\TelegramController\v2\Register\VIP;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;
use Illuminate\Validation\Rules\Password;

trait Register
{
    use NormalUser, BusinussOwner, Seller, RealEstate, VIP, PropertyApplicant;

    public function __construct()
    {
        $this->currentLang();
    }

    public function register(Api $t, Update $u): void
    {
        $this->setLanguage();
        $text = __("In which category do you want to register?");
        // $text = st()->registerOptionText;
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->registerKeyboard(),
        ]);
        $this->updateLastMessage($text);
        $this->updateLastRequestId($r->messageId);
    }

    public function registerKeyboard()
    {
        $button = Keyboard::button([
            'text' => __('Normal User') . ' 👤',
        ]);
        $button1 = Keyboard::button([
            'text' => __('Help') . ' 📝👤',
        ]);
        $button2 = Keyboard::button([
            'text' => __('Seller') . ' 🛒',
        ]);
        $button3 = Keyboard::button([
            'text' => __('Help') . ' 📝🛒',
        ]);
        $button4 = Keyboard::button([
            'text' => __('Business Owner') . ' 💼',
        ]);
        $button5 = Keyboard::button([
            'text' => __('Help') . ' 📝💼',
        ]);
        $button6 = Keyboard::button([
            'text' => __('Real Estate') . ' 🏘',
        ]);
        $button7 = Keyboard::button([
            'text' => __('Help') . ' 📝🏘',
        ]);
        $button8 = Keyboard::button([
            'text' => __('Property Applicant') . ' 🏠',
        ]);
        $button9 = Keyboard::button([
            'text' => __('Help') . ' 📝🏠',
        ]);
        $button10 = Keyboard::button([
            'text' => __('Return To Main Menu') . ' ↩️',
        ]);

        if (config('app.locale') === 'fa') {
            $keyboard = Keyboard::make()
                ->row($button1, $button)
                ->row($button3, $button2)
                ->row($button5, $button4)
                ->row($button7, $button6)
                ->row($button9, $button8)
                ->row($button10);
        } else {
            $keyboard = Keyboard::make()
                ->row($button, $button1)
                ->row($button2, $button3)
                ->row($button4, $button5)
                ->row($button6, $button7)
                ->row($button8, $button9)
                ->row($button10);
        }

        return $keyboard;
    }

    public function sharePhone(Api $t, Update $u): void
    {
        $this->setLanguage();
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
        $text = st()->registerNormalUserText;

        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $keyboard,
        ]);
        $this->updateLastRequestId($r->messageId);
        $field = 'registerMessageId';
        $value = $r->messageId;
        $user = auth()->user();
        $x = $user->extra ?? new stdClass();
        $x->{$field} = $value;
        $user->update(['extra' => $x, 'telegram_last_method' => 'sharePhone']);
    }

    public function registerStore(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $this->setLanguage();
        $this->registerUser($t, $u, $m);
    }

    public function updateUser($user, $code, $phone, $role)
    {
        $auth2 = auth()->user();
        $auth = new User($auth2->toArray());
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        if ($auth2->forceDelete()) {
            $user->name ?: $user->name = $auth->name;
            $user->first_name ?: $user->first_name = $auth->first_name;
            $user->last_name ?: $user->last_name = $auth->last_name;
            $user->country_code = $code;
            $user->phone = $phone;
            $user->birthday ?: $user->birthday = $auth->birthday;
            $user->address ?: $user->address = $auth->address;
            $user->description ?: $user->description = $auth->description;
            $user->rule ?: $user->rule = $role;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function registerEmailRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[6]['keyText'], 'registerEmail');
    }

    public function registerEmailStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store(
            $t,
            $u,
            $m,
            'registerEmail',
            'email',
            function ($t, $u, $m, $data) {
                return \Validator::make([$data => $m->text], [
                    $data => st()->profileKeyboard[6]['keyRule'] . '|unique:users,email',
                ]);
            },
            function ($t, $u, $m) {
                $this->updateUserExtra(function ($x) use ($m) {
                    auth()
                        ->user()
                        ->update(['email' => $m->text]);

                    return $x;
                });
            },
            null,
            'registerPasswordRequest'
        );
    }

    public function registerPasswordRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[2]['keyText'], 'registerPassword');
    }

    public function registerPasswordStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store(
            $t,
            $u,
            $m,
            'registerPassword',
            'password',
            function ($t, $u, $m, $data) {
                return \Validator::make([$data => $m->text], [
                    $data => Password::defaults(),
                ]);
            },
            function ($t, $u, $m) {
                $this->updateUserExtra(function ($x) use ($m) {
                    auth()
                        ->user()
                        ->update(['password' => bcrypt($m->text)]);

                    return $x;
                });
            },
            null,
            'completeRegister'
        );
    }

    public function completeRegister(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        $this->successMessage(st()->registerSuccess);
        $this->startBack($t, $u);
    }

    public function registerUser(Api $t, Update $u, Message|Collection|EditedMessage $m, $role = 'customer')
    {
        $code = $this->seperatePhoneAndCountryCode($m->contact->phoneNumber)['code'];
        $phone = $this->seperatePhoneAndCountryCode($m->contact->phoneNumber)['phone'];

        if($code !== "+1"){
            $this->errorMessage(st()->registerPhoneError);
            $this->reset();
            $this->startBack($t, $u);
        }else{
            if ($user = $this->isRegistered($phone, $code)) { // User exists with phone and country code
                if ($user->email && $user->has_password && $user->telegram_id) { // Usesr has Email and password send already exists message
                    $user->update([
                        'phone_verified_at' => now()
                    ]);
                    $text = st()->alreadyRegisterText;
                    $t->sendMessage([
                        'chat_id' => $u->getChat()->id,
                        'message_id' => $this->getLastMessageId(),
                        'text' => $text,
                    ]);
                    $this->start($t, $u);
                } elseif ($user->email && $user->has_password && !$user->telegram_id) { // user with phone exists but has no email and password and redirect to email
                    $auth = auth()->user();
                    $user->update(['telegram_id' => $auth?->telegram_id]);
                    DB::statement('SET FOREIGN_KEY_CHECKS=0');
                    $auth?->forceDelete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1');
                    // $this->updateUser($user);
                    $text = st()->alreadyRegisterText;
                    $t->sendMessage([
                        'chat_id' => $u->getChat()->id,
                        'message_id' => $this->getLastMessageId(),
                        'text' => $text,
                    ]);
                    $this->start($t, $u);
                } else { // user with phone exists but has no email and password and redirect to email
                    $this->updateUser($user, $code, $phone, $role);
                    if (auth()?->user() && !auth()->user()->subscription) {
                        RegisterEvent::dispatch(auth()->user());
                    }
                    $this->updateLastMessage();
                    $this->registerEmailRequest($t, $u, $m);
                }
            } else { // user not exists and redirect to email
                auth()
                    ->user()
                    ->update([
                        'rule' => $role,
                        'phone' => $phone,
                        'country_code' => $code,
                        'phone_verified_at' => now()
                    ]);

                if (auth()?->user() && !auth()->user()->subscription && $role !== 'vip') {
                    RegisterEvent::dispatch(auth()->user(), $role, 'Telegram');
                    $this->updateLastMessage();
                    $this->registerEmailRequest($t, $u, $m);
                    Log::info('there is user, user has no subscription and role is not vip');
                } elseif (auth()?->user() && !auth()->user()->subscription && $role === 'vip') {
                    RegisterEvent::dispatch(auth()->user(), $role, 'Telegram');
                    $this->updateLastMessage();
                    // $this->registerEmailRequest($t, $u, $m);
                    $this->sendVipMessage($t, $u);
                    Log::info('there is user, user has no subscription and role is vip');
                } else {
                    $this->updateLastMessage();
                    $this->registerEmailRequest($t, $u, $m);
                    Log::info('there is no user or user has subscription');
                }
            }
        }

    }

    /**
     * Seperate Code and Phone number
     *
     * @param string $phoneNumber
     * @return array
     */
    public function seperatePhoneAndCountryCode(string $phoneNumber) : array
    {
        $list = [
            '1',
            '98',
        ];
        $s = Str::of($phoneNumber);
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

        return [
            'code' => $code,
            'phone' => $phone,
        ];
    }

    public function sendVipMessage(Api $t, Update $u)
    {
        $this->setLanguage();
        $b_1 = Keyboard::inlineButton([
            'text' => __('Vip Plans'),
            'url' => route('front.panel.user.plans.vip')
        ]);
        $b_2 = Keyboard::inlineButton([
            'text' => __('Return'),
            'callback_data' => 'register',
        ]);
        $keyboard = Keyboard::make()
            ->inline()
            ->row($b_1)
            ->row($b_2);
        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => __('messages.telegram.vip_plan_purchase'),
            'reply_markup' => $keyboard,
        ]);
    }
}
