<?php

namespace App\Http\Controllers\TelegramController\v2;

use App\Events\ProfileEvent;
use App\Events\ReferralScoreEvent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait EditProfile
{
    public function editProfile(Api $t, Update $u): void
    {
        $text = st()->profileText;
        $text .= $this->flashMassage();
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->editProfileKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function editProfileKeyboard(): Keyboard
    {
        $inlineButton2 = Keyboard::inlineButton([
            'text' => auth()->user()->name ?? '❌',
            'callback_data' => 'profileFullNameEditRequest',
        ]);
        $inlineButton3 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[0]['keyName'],
            'callback_data' => 'profileFullNameEditRequest',
        ]);
        $inlineButton4 = Keyboard::inlineButton([
            'text' => auth()
                ->user()
                ->getMedia('profile')
                ->count() ? '✅' : '❌',
            'callback_data' => 'profileAvatarEditRequest',
        ]);
        $inlineButton5 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[1]['keyName'],
            'callback_data' => 'profileAvatarEditRequest',
        ]);
        $inlineButton6 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[2]['keyName'],
            'callback_data' => 'profilePasswordEditRequest',
        ]);
        $inlineButton7 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[3]['keyName'],
            'callback_data' => 'start',
        ]);
        $inlineButton8 = Keyboard::inlineButton([
            'text' => auth()->user()->first_name ?? '❌',
            'callback_data' => 'profileFirstNameEditRequest',
        ]);
        $inlineButton9 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[4]['keyName'],
            'callback_data' => 'profileFirstNameEditRequest',
        ]);
        $inlineButton10 = Keyboard::inlineButton([
            'text' => auth()->user()->last_name ?? '❌',
            'callback_data' => 'profileLastNameEditRequest',
        ]);
        $inlineButton11 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[5]['keyName'],
            'callback_data' => 'profileLastNameEditRequest',
        ]);
        $inlineButton12 = Keyboard::inlineButton([
            'text' => auth()->user()->email ?? '❌',
            'callback_data' => 'profileEmailEditRequest',
        ]);
        $inlineButton13 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[6]['keyName'],
            'callback_data' => 'profileEmailEditRequest',
        ]);
        $inlineButton14 = Keyboard::inlineButton([
            'text' => auth()->user()->address ?? '❌',
            'callback_data' => 'profileAddressEditRequest',
        ]);
        $inlineButton15 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[7]['keyName'],
            'callback_data' => 'profileAddressEditRequest',
        ]);
        $inlineButton16 = Keyboard::inlineButton([
            'text' => auth()->user()->description ?? '❌',
            'callback_data' => 'profileDescriptionEditRequest',
        ]);
        $inlineButton17 = Keyboard::inlineButton([
            'text' => st()->profileKeyboard[8]['keyName'],
            'callback_data' => 'profileDescriptionEditRequest',
        ]);

        return Keyboard::make()
            ->inline()
            // ->row($inlineButton, $inlineButton1)
            ->row($inlineButton8, $inlineButton9)
            ->row($inlineButton10, $inlineButton11)
            ->row($inlineButton2, $inlineButton3)
            ->row($inlineButton12, $inlineButton13)
            ->row($inlineButton14, $inlineButton15)
            // ->row($inlineButton16, $inlineButton17)
            ->row($inlineButton4, $inlineButton5)
            ->row($inlineButton6)
            ->row($inlineButton7);
    }

    //profile name
    public function profileFullNameEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[0]['keyText'], 'profileFullNameEdit');
    }

    public function profileFullNameEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
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
            if ($this->calculateRegistrationProgress() === 100) {
                ProfileEvent::dispatch(auth()->user());
            }
        });
        $this->editProfile($t, $u, $m);
    }

    //profile avatar
    public function profileAvatarEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[1]['keyText'], 'profileAvatarEdit');
    }

    public function profileAvatarEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileAvatar', 'image', function ($t, $u, $m, $data) {
            return \Validator::make([], []);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($t, $u, $m) {
                if ($m->detectType() == 'photo') {

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
                    // $t->deleteMessage([
                    //     'chat_id' => $u->getChat()->id,
                    //     'message_id' => $m->messageId,
                    // ]);
                    if ($this->calculateRegistrationProgress() === 100) {
                        ProfileEvent::dispatch(auth()->user());
                    }
                } else {
                    // $text = "The avatar must be type of image.";
                    // $keyboard = Keyboard::make();
                    // $keyboard->row(Keyboard::button([
                    //     'text' => auth()->user()->isLangFa() ? "بازگشت" : "Return",
                    // ]));
                    // $t->sendMessage([
                    //     'chat_id' => $u->getChat()->id,
                    //     'text' => $text,
                    // ]);
                    // $this->profileAvatarEditRequest($t, $u, $m);
                }
                return $x;
            });
            // $this->profile($t, $u);
        });
        $this->editProfile($t, $u, $m);
    }

    //profile password
    public function profilePasswordEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[2]['keyText'], 'profilePasswordEdit');
    }

    public function profilePasswordEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
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
                if ($this->calculateRegistrationProgress() === 100) {
                    ProfileEvent::dispatch(auth()->user());
                }
                return $x;
            });
            // $this->profile($t, $u);
        });
        // $this->editProfile(st()->registerSuccess);
        $this->completedProfile($t, $u);
    }

    //profile first_name
    public function profileFirstNameEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[4]['keyText'], 'profileFirstNameEdit');
    }

    public function profileFirstNameEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
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
                if ($this->calculateRegistrationProgress() === 100) {
                    ProfileEvent::dispatch(auth()->user());
                }
                return $x;
            });
            // $this->profile($t, $u);
        });

        $this->editProfile($t, $u, $m);
    }

    //profile last_name
    public function profileLastNameEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[5]['keyText'], 'profileLastNameEdit');
    }

    public function profileLastNameEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
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
                if ($this->calculateRegistrationProgress() === 100) {
                    ProfileEvent::dispatch(auth()->user());
                }
                return $x;
            });
            // $this->profile($t, $u);
        });
        $this->editProfile($t, $u, $m);
    }

    //profile email
    public function profileEmailEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[6]['keyText'], 'profileEmailEdit');
    }

    public function profileEmailEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
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
                if ($this->calculateRegistrationProgress() === 100) {
                    ProfileEvent::dispatch(auth()->user());
                }
                return $x;
            });
            // $this->profile($t, $u);
        });
        $this->editProfile($t, $u, $m);
    }

    //profile address
    public function profileAddressEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[7]['keyText'], 'profileAddressEdit');
    }

    public function profileAddressEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
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
                if ($this->calculateRegistrationProgress() === 100) {
                    ProfileEvent::dispatch(auth()->user());
                }
                return $x;
            });
            // $this->profile($t, $u);
        });
        $this->editProfile($t, $u, $m);
    }

    //profile description
    public function profileDescriptionEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[8]['keyText'], 'profileDescriptionEdit');
    }

    public function profileDescriptionEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
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
                if ($this->calculateRegistrationProgress() === 100) {
                    ProfileEvent::dispatch(auth()->user());
                }
                return $x;
            });
            $this->profile($t, $u);
        });
    }

    //profile email
    public function profileReferralCodeEditRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->requestProfile($t, $u, $m, st()->profileKeyboard[10]['keyText'], 'profileReferralCodeEdit');
    }

    public function profileReferralCodeEditStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->store($t, $u, $m, 'profileReferralCode', 'referral_code', function ($t, $u, $m, $data) {
            return \Validator::make([$data => $m->text], [
                $data => st()->profileKeyboard[10]['keyRule'],
            ]);
        }, function ($t, $u, $m) {
            $this->updateUserExtra(function ($x) use ($m) {
                ReferralScoreEvent::dispatch(auth()->user());

                return $x;
            });
            // $this->profile($t, $u);
        });
        $this->editProfile($t, $u, $m);
    }
}
