<?php

namespace App\Http\Controllers\TelegramController\v2;

use App\Models\Ad\Attribute;
use App\Models\Discount;
use App\Models\ScoreCategory;
use App\Models\User;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;


trait Methods
{
    public $lang;

    //methods
    public function reset()
    {
        if (Auth::check()) {
            Auth::user()->update([
                'telegram_last_message' => null,
                'telegram_last_method' => null,
            ]);
        }
    }

    public function setLanguage()
    {
        auth()?->user()?->lang ? App::setLocale(Auth::user()->lang ?: config('app.locale')) : null;
        $this->lang = config('app.locale');
    }

    public function sendMessageTextWithKeyboard(Api $t, Update $u, string $text, Keyboard $keyboard)
    {
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => $text,
            'reply_markup' => $keyboard,
            'parse_mode' => 'Markdown'
        ]);
        // $this->updateLastMessage($text);
        $this->updateLastRequestId($r->messageId);
    }

    public function sendMessageText(Api $t, Update $u, $text)
    {
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => $text,
            'parse_mode' => 'Markdown'
        ]);
        // $this->updateLastMessage($text);
        $this->updateLastRequestId($r->messageId);
    }

    public function isMember($t, $u)
    {
        $response = $t->getChatMember([
            'chat_id' =>  st()->channel_id ?? "@kiuskcanada",
            'user_id' => auth()->user()->telegram_id,
        ]);

        return ($response['ok'] && $response['result']['status'] !== 'left');
    }

    public function returnToHomeKeyboard(): Keyboard
    {
        return Keyboard::make()->row(Keyboard::button([
            'text' => __("Return To Main Menu") . ' ↩️',
        ]));
    }

    public function confirmImageKeyboard(): Keyboard
    {
        return Keyboard::make()->inline()->row(Keyboard::inlineButton([
            'text' => __("Confirm") . ' ✅',
            'callback_data' => 'adsCreateConfirmImage'
        ]))->row(Keyboard::inlineButton([
            'text' => __("Return To Main Menu") . ' ↩️',
            'callback_data' => 'startBack'
        ]));
    }

    public function skipKeyboard(): Keyboard
    {
        return Keyboard::make()->row(Keyboard::button([
            'text' => __("Skip This Step") . ' ➡️',
        ]));
    }

    public function skipToMethod(Api $t, Update $u, Message|Collection|EditedMessage $m)
    {
        if (auth()->user()?->telegram_next_method)
            $this->{auth()->user()->telegram_next_method}($t, $u, $m);
    }

    public function isTypeRealEstate()
    {
        return auth()->user()?->extra?->adsCreate?->type === 'real_estate';
    }

    public function isSaleTypeRent()
    {
        return auth()->user()?->extra?->adsCreate?->sale_type === 'rent';
    }

    public function facilityCheck($id, $type, $createOrEdit = 'adsCreate'): bool
    {
        $user = auth()->user();
        $x = $user?->extra?->$createOrEdit?->$type ?? [];
        return in_array($id, $x);
    }

    public function selectFacilities($prop, $facilityId)
    {
        $prop[] = $facilityId;
        $prop = array_filter($prop, function ($value) use ($facilityId) {
            return $value != $facilityId;
        });
        $prop = array_unique($prop);
        return $prop;
    }

    public function facilityConfirmButton($callback)
    {
        return Keyboard::inlineButton([
            'text' => __("Confirm") . ' ✅',
            'callback_data' => $callback
        ]);
    }

    public function removeKeyboard($t, $u)
    {
        $reply_markup = Keyboard::remove([
            'remove_keyboard' => true,
            'selective' => false,
        ]);

        $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'text' => 'Removing Keyboard ...',
            'reply_markup' => $reply_markup,
        ]);
    }

    public function updateLastMessage(string $text = null): void
    {
        auth()
            ->user()
            ->update([
                'telegram_last_message' => $text,
            ]);
    }

    public function getLastMessage()
    {
        return auth()->user()->telegram_last_message;
    }

    public function updateLastMessageId($id = null): void
    {
        auth()
            ->user()
            ->update([
                'telegram_last_message_id' => $id,
            ]);
    }

    public function updateLastRequestId($id = null): void
    {
        auth()
            ->user()
            ->update([
                'telegram_last_request_id' => $id,
            ]);
    }

    public function getLastMessageId()
    {
        return auth()->user()->telegram_last_message_id;
    }

    public function getLastRequestId()
    {
        return auth()->user()->telegram_last_request_id;
    }

    public function deleteMessageClinet(Api $t, Update $u): void
    {
        $t->deleteMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $u->getMessage()->messageId,
        ]);
    }

    public function login(\Telegram\Bot\Objects\User $from): void
    {
        auth()->login(User::firstOrCreate(['telegram_id' => $from->id], [
            'name' => $from->firstName . ' ' . $from->lastName . ' telegram',
            'email' => $from->id . '@telegram.telegram',
            'lang' => 'fa',
            'telegram_first_name' => $from->firstName,
            'telegram_last_name' => $from->lastName,
            'telegram_username' => $from->username,
        ]));
        if (auth()->user()->last_online_at?->diffInMinutes(now()) !== 0) {
            DB::table("users")
                ->where("id", auth()->user()->id)
                ->update(["last_online_at" => now()]);
        }
        if (is_null(auth()->user()->lang)) {
            DB::table("users")
                ->where("id", auth()->user()->id)
                ->update(["lang" => 'fa']);
        }
    }

    public function registrationCheck(Api $t, Update $u, $phone)
    {
        if ($this->isRegistered($phone)) {
            $text = "شما قبلا در سایت ثیت نام کرده اید";
            $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => $text,
            ]);
            $this->startBack($t, $u);
            return;
        }
    }

    public function isRegistered($phone, $code = null): User|null
    {
        return User::where('phone', $phone)
            ->where('country_code', $code)
            ->first();
    }

    public function deleteLastMessage(Api $t, Update $u): void
    {
        $telegramLastMessageId = $this->getLastMessageId();
        if ($telegramLastMessageId) {
            // $t->deleteMessage([
            //     'chat_id' => $u->getChat()->id,
            //     'message_id' => $telegramLastMessageId,
            // ]);
        }
    }

    public function deleteLastRequest(Api $t, Update $u): void
    {
        $telegramLastRequestId = $this->getLastRequestId();
        if ($telegramLastRequestId) {
            // $t->deleteMessage([
            //     'chat_id' => $u->getChat()->id,
            //     'message_id' => $telegramLastRequestId,
            // ]);
        }
    }

    public function pagination(Collection|array $ads, int $adsCount, int $perPage, mixed $page, Keyboard $keyboard): void
    {
        $pagination = new LengthAwarePaginator($ads, $adsCount, $perPage, $page, [
            'path' => '',
            'pageName' => '',
        ]);
        if ($pagination->hasPages()) {
            $paginationInlineButton = $pagination->linkCollection()
                ->reject(function ($item) {
                    return $item['url'] == null;
                })
                ->map(function ($item) {
                    $pageNumber = \Str::of($item['url'])
                        ->after('?=');
                    $label = $item['label'];
                    $x = \Str::of($label);
                    !$x->contains("Next") ?: $label = '▶';
                    !$x->contains("Previous") ?: $label = '◀';
                    $params = [
                        'text' => $label . ($item['active'] === true ? '✅' : ''),
                        'callback_data' => 'adsListPage' . $pageNumber,
                    ];

                    return Keyboard::inlineButton($params);
                })
                ->toArray();
            $keyboard->row(...$paginationInlineButton);
        }
    }

    public function updateUserExtra($function): void
    {
        // $user = auth()->user();
        // $x = $user->extra ?? new stdClass();
        // $x = $function($x);
        // $user->update(['extra' => $x,]);

        $user = auth()->user();
        $extra = $user->extra;
        $data = $extra ? (array) $extra : [];
        $data = $function((object) $data);
        $user->update(['extra' => (object) $data]);
    }

    public function flashMassage(): string
    {
        $m = '';
        if (isset(auth()->user()?->extra?->errorMessage)) {
            $m .= PHP_EOL . '🚫' . auth()->user()->extra?->errorMessage . '🚫
            ';
            // $m .= now()->millisecond;
            $this->updateUserExtra(function ($x) {
                unset($x->errorMessage);

                return $x;
            });
        } elseif (isset(auth()->user()->extra?->successMessage)) {
            $m .= PHP_EOL . '✅' . auth()->user()->extra?->successMessage . '✅
            ';
            $this->updateUserExtra(function ($x) {
                unset($x->successMessage);

                return $x;
            });
        }

        return $m;
    }

    public function errorMessage(string $message): void
    {
        $this->updateUserExtra(function ($x) use ($message) {
            $x->errorMessage = '' . $message . '';

            return $x;
        });
    }

    public function successMessage(string $message): void
    {
        $this->updateUserExtra(function ($x) use ($message) {
            $x->successMessage = '' . $message . '';

            return $x;
        });
    }

    /**
     * Updates the last method and last message of the user and displays the flash message with a return button
     *
     * @param Api $t
     * @param Update $u
     * @param Message|Collection|EditedMessage $m
     * @param string $text
     * @param string $method
     * @param int $attributeId
     * @return void
     */
    public function request(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void {
        $text .= $this->flashMassage();
        $m;
        $keyboard = Keyboard::make();
        $keyboard->row(Keyboard::button([
            'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
        ]));
        $user = auth()->user();
        $user->update([
            'telegram_last_message' => $text,
            'telegram_last_method' => $method . 'Store' . $attributeId,
        ]);
        if ($user->wasChanged('telegram_last_message')) {
            // $this->deleteLastMessage($t, $u);
            $this->deleteLastRequest($t, $u);
            $response = $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
            $this->updateLastRequestId($response->messageId);
            // $r = $t->editMessageText([
            //                           'chat_id' => $u->getChat()->id,
            //                           'message_id' => $this->getLastMessageId(),
            //                           'text' => $text,
            //                           'reply_markup' => $keyboard,
            //                          ]);
        }else{
            $response = $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
        }
    }

    public function inlineRequests(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void {
        $text .= $this->flashMassage();
        $m;
        $keyboard = Keyboard::make()
            ->inline();
        /**
         * @var Attribute $attribute
         */ //  $attribute = $this->getAttr($attributeId);
        //         if (count($attribute->options)) {
        //         foreach ($attribute->options as $key => $option) {
        // $keyboard->row(Keyboard::inlineButton([
        //                                         'text' => $option->name,
        //                                         'callback_data' => 'adsCreate'
        //                                         ]));
        //         }
        //         }
        $keyboard->row(Keyboard::inlineButton([
            'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
            'callback_data' => 'adsCreate',
        ]));
        $user = auth()->user();
        $user->update([
            'telegram_last_message' => $text,
            'telegram_last_method' => $method . 'Store' . $attributeId,
        ]);
        if ($user->wasChanged('telegram_last_message')) {
            $r = $t->editMessageText([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
        }
    }

    public function requestEdit(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void {
        $text .= $this->flashMassage();
        $m;
        $keyboard = Keyboard::make()
            ->inline();
        /**
         * @var Attribute $attribute
         */ //  $attribute = $this->getAttr($attributeId);
        //         if (count($attribute->options)) {
        //         foreach ($attribute->options as $key => $option) {
        // $keyboard->row(Keyboard::inlineButton([
        //                                         'text' => $option->name,
        //                                         'callback_data' => 'adsCreate'
        //                                         ]));
        //         }
        //         }
        $keyboard->row(Keyboard::inlineButton([
            'text' => __('Return to ad'),
            'callback_data' => 'adsEdit' . auth()->user()->extra->adsEdit->id,
        ]));
        $user = auth()->user();
        $user->update([
            'telegram_last_message' => $text,
            'telegram_last_method' => $method . 'Store' . $attributeId,
        ]);
        if ($user->wasChanged('telegram_last_message')) {
            $r = $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
            $this->updateLastRequestId($r->messageId);
        }
    }

    public function requestAdvertisementEdit(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void {
        $text .= $this->flashMassage();
        $m;
        $keyboard = Keyboard::make()
            ->inline();

        $keyboard->row(Keyboard::inlineButton([
            'text' => __('Return'),
            'callback_data' => 'advertisementsEdit' . auth()->user()->extra->advertisementsEdit->id,
        ]));
        $user = auth()->user();
        $user->update([
            'telegram_last_message' => $text,
            'telegram_last_method' => $method . 'Store' . $attributeId,
        ]);
        if ($user->wasChanged('telegram_last_message')) {
            $r = $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
            $this->updateLastRequestId($r->messageId);
        }
    }

    public function requestProfile(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null,
        $skip = null
    ): void {
        $text .= $this->flashMassage();
        $m;
        $keyboard = Keyboard::make();
        $keyboard->row(Keyboard::button([
            'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
        ]));
        if ($skip) {
            $keyboard->row(Keyboard::button([
                'text' => $skip,
            ]));
        }
        $user = auth()->user();
        $user->update([
            'telegram_last_message' => $text,
            'telegram_last_method' => $method . 'Store' . $attributeId,
        ]);
        if ($user->wasChanged('telegram_last_message')) {
            $this->deleteLastRequest($t, $u);
            $response = $t->sendMessage([
                'chat_id' => $u->getChat()->id,
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
            $this->updateLastRequestId($response->messageId);
        }
    }
    public function requestInlineProfile(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void {
        $text .= $this->flashMassage();
        $m;
        $keyboard = Keyboard::make()
            ->inline();
        /**
         * @var Attribute $attribute
         */ //  $attribute = $this->getAttr($attributeId);
        //         if (count($attribute->options)) {
        //         foreach ($attribute->options as $key => $option) {
        // $keyboard->row(Keyboard::inlineButton([
        //                                         'text' => $option->name,
        //                                         'callback_data' => 'adsCreate'
        //                                         ]));
        //         }
        //         }
        $keyboard->row(Keyboard::inlineButton([
            'text' => 'بازگشت',
            'callback_data' => 'profile',
        ]));
        $user = auth()->user();
        $user->update([
            'telegram_last_message' => $text,
            'telegram_last_method' => $method . 'Store' . $attributeId,
        ]);
        if ($user->wasChanged('telegram_last_message')) {
            $r = $t->editMessageText([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
        }
    }

    /**
     * Baesd on the input method redirects to the selected method to store data,
     * if the validation fails it wil return to the previous method
     *
     * @param Api $t
     * @param Update $u
     * @param Message|Collection|EditedMessage $m
     * @param string $method
     * @param string $data
     * @param \Closure $validateMethod
     * @param \Closure $callback
     * @param int $id
     * @param string $nextStep
     * @return void
     */
    public function store(
        Api      $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $method,
        string $data,
        \Closure $validateMethod,
        \Closure $callback,
        $id = null,
        $nextStep = null
    ): void {
        $requestMethod = $method . 'Request';
        $validation = $validateMethod($t, $u, $m, $data);
        if ($validation->fails()) {
            $this->errorMessage(implode('', $validation->messages()
                ->messages()[$data]));
            // $t->deleteMessage([
            //     'chat_id' => $u->getChat()->id,
            //     'message_id' => $m->messageId,
            // ]);
            $this->{$requestMethod}($t, $u, $m, $id);
        } else {
            $callback($t, $u, $m);
            $this->deleteLastRequest($t, $u);
            // $t->deleteMessage([
            //     'chat_id' => $u->getChat()->id,
            //     'message_id' => $m->messageId,
            // ]);
            auth()
                ->user()
                ->update([
                    'telegram_last_message' => '',
                    'telegram_last_method' => '',
                ]);
            if ($nextStep) {
                $this->{$nextStep}($t, $u, $m);
            }
        }
    }

    public function requestOption(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void {
        $text .= $this->flashMassage();
        $m;
        $keyboard = Keyboard::make()
            ->inline();
        /**
         * @var Attribute $attribute
         */
        $attribute = $this->getAttr($attributeId);
        $this->updateUserExtra(function ($x) use ($m, $attributeId) {
            // dump('**********1', $x);
            $x->attributeIdTypeSelect = $attributeId;
            // dump('**********2', $x);
            return $x;
        });
        if ($attribute?->options && count($attribute?->options)) {
            foreach ($attribute->options as $key => $option) {
                $keyboard->row(Keyboard::inlineButton([
                    'text' => $option->name,
                    'callback_data' => $method . 'Store' . $key,
                ]));
            }
        }
        $keyboard->row(Keyboard::inlineButton([
            'text' => 'بازگشت',
            'callback_data' => 'adsCreate',
        ]));
        $user = auth()->user();
        $user->update([
            'telegram_last_message' => $text,
            'telegram_last_method' => $method . 'Store' . $attributeId,
        ]);
        if ($user->wasChanged('telegram_last_message')) {
            $r = $t->editMessageText([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
        }
    }

    public function requestEditOption(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void {
        $text .= $this->flashMassage();
        $m;
        $keyboard = Keyboard::make()
            ->inline();
        /**
         * @var Attribute $attribute
         */
        $attribute = $this->getAttr($attributeId, 'adsEdit');
        $this->updateUserExtra(function ($x) use ($m, $attributeId) {
            // dump('**********1', $x);
            $x->attributeIdTypeSelect = $attributeId;
            // dump('**********2', $x);
            return $x;
        });
        if ($attribute?->options && count($attribute?->options)) {
            foreach ($attribute->options as $key => $option) {
                $keyboard->row(Keyboard::inlineButton([
                    'text' => $option->name,
                    'callback_data' => $method . 'Store' . $key,
                ]));
            }
        }
        $keyboard->row(Keyboard::inlineButton([
            'text' => 'بازگشت',
            'callback_data' => 'adsEdit',
        ]));
        $user = auth()->user();
        $user->update([
            'telegram_last_message' => $text,
            'telegram_last_method' => $method . 'Store' . $attributeId,
        ]);
        if ($user->wasChanged('telegram_last_message')) {
            $r = $t->editMessageText([
                'chat_id' => $u->getChat()->id,
                'message_id' => $this->getLastMessageId(),
                'text' => $text,
                'reply_markup' => $keyboard,
            ]);
        }
    }

    public function storeOption(
        Api      $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $method,
        string $data,
        \Closure $validateMethod,
        \Closure $callback,
        $id = null
    ): void {
        $requestMethod = $method . 'Request';
        $validation = $validateMethod($t, $u, $m, $data);
        // dump(2.1121);
        if ($validation->fails()) {
            $this->errorMessage(implode('', $validation->messages()
                ->messages()[$data]));
            $t->deleteMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $m->messageId,
            ]);
            $this->{$requestMethod}($t, $u, $m, $id);
        } else {
            // dump(2.3333);
            $callback($t, $u, $m);
            $this->adsCreate($t, $u);
            // $t->deleteMessage([
            //         'chat_id' => $u->getChat()->id,
            //         'message_id' => $m->messageId,
            //         ]);
            auth()
                ->user()
                ->update([
                    'telegram_last_message' => '',
                    'telegram_last_method' => '',
                ]);
        }
    }

    public function storeEditOption(
        Api      $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $method,
        string   $data,
        \Closure $validateMethod,
        \Closure $callback,
        $id = null
    ): void {
        $requestMethod = $method . 'Request';
        $validation = $validateMethod($t, $u, $m, $data);
        // dump(2.1121);
        if ($validation->fails()) {
            $this->errorMessage(implode('', $validation->messages()
                ->messages()[$data]));
            $t->deleteMessage([
                'chat_id' => $u->getChat()->id,
                'message_id' => $m->messageId,
            ]);
            $this->{$requestMethod}($t, $u, $m, $id);
        } else {
            // dump(2.3333);
            $callback($t, $u, $m);
            $this->adsEdit($t, $u);
            // $t->deleteMessage([
            //         'chat_id' => $u->getChat()->id,
            //         'message_id' => $m->messageId,
            //         ]);
            auth()
                ->user()
                ->update([
                    'telegram_last_message' => '',
                    'telegram_last_method' => '',
                ]);
        }
    }

    public function getAttr($attributeId, $source = 'adsCreate'): mixed
    {
        $attributes = auth()->user()->extra->{$source}->attributes;
        $attribute = collect($attributes)->firstWhere('id', $attributeId);

        return $attribute;
    }

    // Score Methods

    public function loadUser()
    {
        return Auth::user()->loadSum(['scores' => function ($query) {
            $query->where('spent', false)->where('claimed', true);
        }], 'score')
            ->loadSum('totalNotClaimedScores', 'score')
            ->loadSum('totalSpentScores', 'score')
            ->loadSum('commentScores', 'score')
            ->loadSum('reviewScores', 'score')
            ->loadSum('commentReviewScores', 'score')
            ->loadSum('referralScores', 'score')
            ->loadSum('googleReviewScores', 'score')
            ->loadSum('sendVideoScores', 'score')
            ->loadSum('serviceUsageScores', 'score')
            ->loadSum('rateScores', 'score');
    }

    public function useScores($scoreTypeId)
    {
        $user = auth()->user()->loadSum(['scores' => function ($query) {
            $query->where('spent', false)->where('claimed', true);
        }], 'score');
        $type = ScoreCategory::find($scoreTypeId);
        if ((int)$type->require_score > ($user->scores_sum_score ?? 0)) {
            $this->errorMessage(__('messages.scores.limit_error'));
        } else {
            $this->calculateScoreUsage($user, (int)$type->require_score);
            return $this->createDiscount($scoreTypeId);
        }
    }

    public function createDiscount($scoreTypeId): void
    {
        $discountCode = $this->generateUniqueDiscountCode(auth()->id());
        Discount::create([
            'code' => $discountCode,
            'user_id' => auth()->id(),
            'score_category_id' => $scoreTypeId,
        ]);
    }

    /**
     * Check user with roles that can upgrade to level or not
     *
     * @param string $newRole
     * @return boolean
     */
    public function checkUserRole(string $newRole): bool
    {
        $currentRole = auth()->user()->getRoleNames()->first();
        if (in_array($currentRole, ['real_estate', 'business_owner', 'seller'])) {
            // Prevent changing to any role except "vip"
            if ($newRole !== 'vip') {
                // Redirect back or show an error message
                return false;
            }
        }
        return true;
    }
}
