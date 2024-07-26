<?php

namespace App\Http\Controllers\TelegramController;

use App\Http\Controllers\TelegramController\v2\Scores\Scores;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Password;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Profile
{
    use Scores;

    //profile
    public function profile(Api $t, Update $u): void
    {
        $text = st()->profileText;
        $text .= $this->flashMassage();
        $r = $t->editMessageText([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->profileKeyboard(),
        ]);
    }

    public function profileKeyboard(): Keyboard
    {
        //  $inlineButton = Keyboard::inlineButton([
        //                                  'text' => '❌',
        //                                  'callback_data' => 'profileRuleRequest'
        //                                 ]);
        //  $inlineButton1 = Keyboard::inlineButton([
        //                                   'text' => 'نوع اکانت',
        //                                   'callback_data' => 'profileRuleRequest'
        //                                  ]);
        $inlineButton2 = Keyboard::inlineButton([
            'text' => auth()->user()->name ?? '❌',
            'callback_data' => 'profileFullNameRequest',
        ]);
        $inlineButton3 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[0]['keyName'],
            'callback_data' => 'profileFullNameRequest',
        ]);
        $inlineButton4 = Keyboard::inlineButton([
            'text' => auth()
                ->user()
                ->getMedia('avatar')
                ->count() ? '✅' : '❌',
            'callback_data' => 'profileAvatarRequest',
        ]);
        $inlineButton5 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[1]['keyName'],
            'callback_data' => 'profileAvatarRequest',
        ]);
        $inlineButton6 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[2]['keyName'],
            'callback_data' => 'profilePasswordRequest',
        ]);
        $inlineButton7 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[3]['keyName'],
            'callback_data' => 'startBack',
        ]);
        $inlineButton8 = Keyboard::inlineButton([
            'text' => auth()->user()->first_name ?? '❌',
            'callback_data' => 'profileFirstNameRequest',
        ]);
        $inlineButton9 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[4]['keyName'],
            'callback_data' => 'profileFirstNameRequest',
        ]);
        $inlineButton10 = Keyboard::inlineButton([
            'text' => auth()->user()->last_name ?? '❌',
            'callback_data' => 'profileLastNameRequest',
        ]);
        $inlineButton11 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[5]['keyName'],
            'callback_data' => 'profileLastNameRequest',
        ]);
        $inlineButton12 = Keyboard::inlineButton([
            'text' => auth()->user()->email ?? '❌',
            'callback_data' => 'profileEmailRequest',
        ]);
        $inlineButton13 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[6]['keyName'],
            'callback_data' => 'profileEmailRequest',
        ]);
        $inlineButton14 = Keyboard::inlineButton([
            'text' => auth()->user()->address ?? '❌',
            'callback_data' => 'profileAddressRequest',
        ]);
        $inlineButton15 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[7]['keyName'],
            'callback_data' => 'profileAddressRequest',
        ]);
        $inlineButton16 = Keyboard::inlineButton([
            'text' => auth()->user()->description ?? '❌',
            'callback_data' => 'profileDescriptionRequest',
        ]);
        $inlineButton17 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[8]['keyName'],
            'callback_data' => 'profileDescriptionRequest',
        ]);

        $user = auth()->user()->loadSum(['scores' => function ($query) {
            $query->where('spent', false)->where('claimed', true);
        }], 'score');

        $inlineButtonScore1 = Keyboard::inlineButton([
            'text' => $user->scores_sum_score ?? 0,
            'callback_data' => 'profileScoresRequest',
        ]);
        $inlineButtonScore2 = Keyboard::inlineButton([
            'text' => __('Scores'),
            // 'text' => st()->profileKeyboard[9]['keyName'],
            'callback_data' => 'profileScoresRequest',
        ]);

        return Keyboard::make()
            ->inline()
            // ->row($inlineButton, $inlineButton1)
            ->row($inlineButton8, $inlineButton9)
            ->row($inlineButton10, $inlineButton11)
            ->row($inlineButton2, $inlineButton3)
            ->row($inlineButton12, $inlineButton13)
            ->row($inlineButton14, $inlineButton15)
            ->row($inlineButton16, $inlineButton17)
            ->row($inlineButton4, $inlineButton5)
            ->row($inlineButtonScore1, $inlineButtonScore2)
            ->row($inlineButton6)
            ->row($inlineButton7);
    }

    //profile name
    public function profileFullNameRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[0]['keyText'], 'profileFullName');
    }

    public function profileFullNameStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileFullName', 'name', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->profileKeyboard[0]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                auth()
                    ->user()
                    ->update(['name' => $m->text]);

                return $x;
            });
            $this->profile($t, $u);
        });
    }

    //profile avatar
    public function profileAvatarRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[1]['keyText'], 'profileAvatar');
    }

    public function profileAvatarStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileAvatar', 'image', function ($t, $u, $m, $data) {
            return \Validator::make([], []);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($t, $u, $m) {
                $file = $t->getFile([
                    'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
                ]);
                $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
                auth()
                    ->user()
                    ->getMedia('profile')
                    ->each(function ($item) {
                        $item->delete();
                    });
                auth()
                    ->user()
                    ->addMediaFromUrl($fileUrl)
                    ->toMediaCollection('profile');
                $t->deleteMessage([
                    'chat_id' => $u->getChat()->id,
                    'message_id' => $m->messageId,
                ]);

                return $x;
            });
            $this->profile($t, $u);
        });
    }

    //profile password
    public function profilePasswordRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[2]['keyText'], 'profilePassword');
    }

    public function profilePasswordStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profilePassword', 'password', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => Password::defaults(),
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                auth()
                    ->user()
                    ->update(['password' => bcrypt($m->text)]);

                return $x;
            });
            $this->profile($t, $u);
        });
    }

    //profile first_name
    public function profileFirstNameRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[4]['keyText'], 'profileFirstName');
    }

    public function profileFirstNameStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileFirstName', 'first_name', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->profileKeyboard[4]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                auth()
                    ->user()
                    ->update(['first_name' => $m->text]);

                return $x;
            });
            $this->profile($t, $u);
        });
    }

    //profile last_name
    public function profileLastNameRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[5]['keyText'], 'profileLastName');
    }

    public function profileLastNameStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileLastName', 'last_name', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->profileKeyboard[5]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                auth()
                    ->user()
                    ->update(['last_name' => $m->text]);

                return $x;
            });
            $this->profile($t, $u);
        });
    }

    //profile email
    public function profileEmailRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[6]['keyText'], 'profileEmail');
    }

    public function profileEmailStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileEmail', 'email', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->profileKeyboard[6]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                auth()
                    ->user()
                    ->update(['email' => $m->text]);

                return $x;
            });
            $this->profile($t, $u);
        });
    }

    //profile address
    public function profileAddressRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[7]['keyText'], 'profileAddress');
    }

    public function profileAddressStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileAddress', 'address', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->profileKeyboard[7]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                auth()
                    ->user()
                    ->update(['address' => $m->text]);

                return $x;
            });
            $this->profile($t, $u);
        });
    }

    //profile description
    public function profileDescriptionRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[8]['keyText'], 'profileDescription');
    }

    public function profileDescriptionStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileDescription', 'description', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->profileKeyboard[8]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                auth()
                    ->user()
                    ->update(['description' => $m->text]);

                return $x;
            });
            $this->profile($t, $u);
        });
    }
}
