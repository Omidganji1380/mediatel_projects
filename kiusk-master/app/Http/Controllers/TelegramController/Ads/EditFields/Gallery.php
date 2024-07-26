<?php

namespace App\Http\Controllers\TelegramController\Ads\EditFields;

use Arr;
use Illuminate\Support\Collection;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Gallery
{
 public function adsEditGalleryRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
 {
  $b = Keyboard::inlineButton([
                               'text' => 'پاک‌ کردن همه عکس‌ها',
                               'callback_data' => 'adsEditGalleryRemoveAll'
                              ]);
  $c = Keyboard::inlineButton([
                               'text' => 'بازگشت',
                               'callback_data' => 'adsEdit'
                              ]);
  $keyboard = Keyboard::make()
                      ->inline()
                      ->row($b)
                      ->row($c);
  $text = st()->adsEditKeyboard[4]['keyText'];
  $r = $t->editMessageText([
                            'chat_id' => $u->getChat()->id,
                            'message_id' => $this->getLastMessageId(),
                            'text' => $text,
                            'reply_markup' => $keyboard
                           ]);
  auth()
   ->user()
   ->update([
             'telegram_last_message' => $text,
             'telegram_last_method' => 'adsEditGalleryStore',
            ]);
 }

 public function adsEditGalleryStore(Api $t, Update $u, Message|Collection|EditedMessage $m): void
 {
  $user = auth()->user();
  $keyRule = st()->adsEditKeyboard[4]['keyRule'];
  if ($user->getMedia('adsEditGallery') && $user->getMedia('adsEditGallery')
                                                ->count() < $keyRule) {
   $file = $t->getFile([
                        'file_id' => $m->photo[count($m->photo) - 1]['file_id'],
                       ]);
   $fileUrl = 'http://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $file->filePath;
   $user->addMediaFromUrl($fileUrl)
        ->toMediaCollection('adsEditGallery');
   $t->deleteMessage([
                      'chat_id' => $u->getChat()->id,
                      'message_id' => $m->messageId,
                     ]);
  }
  else {
   $this->errorMessage("تعداد عکس ها حداکثر ${keyRule} عدد باید باشد.");
  }
  session()->put('numberGalleryAddOne', true);
  $this->adsEdit($t, $u);
 }

 public function adsEditGalleryRemoveAll(Api $t, Update $u, Message|Collection|EditedMessage $m)
 {
  $user = auth()->user();
  $user->clearMediaCollection('adsEditGallery');
  $this->adsEdit($t, $u);
 }
}
