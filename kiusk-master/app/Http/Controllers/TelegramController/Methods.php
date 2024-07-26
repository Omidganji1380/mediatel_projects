<?php

namespace App\Http\Controllers\TelegramController;

use App\Models\Ad\Attribute;
use App\Models\User;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Methods
{
    //methods
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

    public function getLastMessageId()
    {
        return auth()->user()->telegram_last_message_id;
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
        if (auth()->user()->last_online_at->diffInMinutes(now()) !== 0) {
            DB::table("users")
              ->where("id", auth()->user()->id)
              ->update(["last_online_at" => now()]);
        }
        if(is_null(auth()->user()->lang)){
            DB::table("users")
              ->where("id", auth()->user()->id)
              ->update(["lang" => 'fa']);
        }
    }

    public function deleteLastMessage(Api $t, Update $u): void
    {
        $telegramLastMessageId = $this->getLastMessageId();
        if ($telegramLastMessageId) {
            $t->deleteMessage([
                               'chat_id' => $u->getChat()->id,
                               'message_id' => $telegramLastMessageId,
                              ]);
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
                                                     ! $x->contains("Next") ?: $label = '▶';
                                                     ! $x->contains("Previous") ?: $label = '◀';
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
        $user = auth()->user();
        $x = $user->extra;
        $x = $function($x);
        $user->update(['extra' => $x,]);
    }

    public function flashMassage(): string
    {
        $m = '';
        if (isset(auth()->user()->extra->errorMessage)) {
            $m .= '
   🚫' . auth()->user()->extra->errorMessage . '🚫
   ';
            $m .= now()->millisecond;
            $this->updateUserExtra(function ($x) {
                unset($x->errorMessage);

                return $x;
            });
        } elseif (isset(auth()->user()->extra->successMessage)) {
            $m .= '
   ✅' . auth()->user()->extra->successMessage . '✅
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

    public function request(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void
    {
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
    ): void
    {
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

    public function requestProfile(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void
    {
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

    public function store(
        Api      $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $method,
        string $data,
        \Closure $validateMethod,
        \Closure $callback,
        $id = null
    ): void
    {
        $requestMethod = $method . 'Request';
        $validation = $validateMethod($t, $u, $m, $data);
        if ($validation->fails()) {
            $this->errorMessage(implode('', $validation->messages()
                                                       ->messages()[$data]));
            $t->deleteMessage([
                               'chat_id' => $u->getChat()->id,
                               'message_id' => $m->messageId,
                              ]);
            $this->{$requestMethod}($t, $u, $m, $id);
        } else {
            $callback($t, $u, $m);
            $t->deleteMessage([
                               'chat_id' => $u->getChat()->id,
                               'message_id' => $m->messageId,
                              ]);
            auth()
             ->user()
             ->update([
                       'telegram_last_message' => '',
                       'telegram_last_method' => '',
                      ]);
        }
    }

    public function requestOption(
        Api $t,
        Update $u,
        Message|Collection|EditedMessage $m,
        string $text,
        string $method,
        $attributeId = null
    ): void
    {
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
    ): void
    {
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
    ): void
    {
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
    ): void
    {
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
}
