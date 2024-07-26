<?php

namespace App\Http\Controllers\TelegramController\v2\Scores;

use App\Models\Discount;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use stdClass;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\EditedMessage;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

trait Scores
{
    //profile
    public function profileScoresRequest(Api $t, Update $u): void
    {
        $this->setLanguage();
        $user = $this->loadUser();
        $registrationProgress = $this->calculateRegistrationProgress();
        $generatedCodes = Discount::whereBelongsTo(auth()->user())->latest()->get();
        $telegramScoreText = __('messages.telegram.user_score_text', [
            'total_score' => $user->scores_sum_score ?? 0,
            'total_used_score' => $user->total_spent_scores_sum_score ?? 0,
            'total_pending_score' => $user->total_not_claimed_scores_sum_score ?? 0,
            'complete_profile' => $registrationProgress,
            'blog_ad_review' => $user->comment_review_scores_sum_score ?? 0,
            'ad_rating' => $user->rate_scores_sum_score ?? 0,
            'google_review' => $user->google_review_scores_sum_score ?? 0,
            'upload_video' => $user->send_video_scores_sum_score ?? 0,
            'use_services' => $user->service_usage_scores_sum_score ?? 0,
            'referral_user' => $user->referral_scores_sum_score ?? 0,
        ]);

        if($generatedCodes->count()){
            $telegramScoreText.= "\n";
            $telegramScoreText.= __('messages.telegram.generated_code_title');
            foreach($generatedCodes as $code){
                $telegramScoreText.= "\n".  $code->scoreCategory?->locale_name . ": <code>" . $code->code . "</code>";
            }
        }

        $telegramScoreText.= $this->flashMassage();
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $telegramScoreText,
            'reply_markup' => $this->scoreKeyboard(),
            'parse_mode' => 'HTML',
        ]);
    }

    public function scoreKeyboard(): Keyboard
    {
        $inlineButtonScore1 = Keyboard::inlineButton([
            'text' => __('Use Scores'),
            'callback_data' => 'useScoresRequest',
        ]);
        $inlineButtonScore2 = Keyboard::inlineButton([
            'text' => __('Back to profile'),
            'callback_data' => 'profile',
        ]);

        return Keyboard::make()
            ->inline()
            // ->row($inlineButton, $inlineButton1)
            ->row($inlineButtonScore1)
            ->row($inlineButtonScore2);
    }

    // Spend Score Request
    public function useScoresRequest(Api $t, Update $u, Message|Collection|EditedMessage $m): void
    {
        $this->setLanguage();
        // $text = __('messages.scores.usage_description');
        $text = st()->useScoreText;
        $r = $t->sendMessage([
            'chat_id' => $u->getChat()->id,
            'message_id' => $this->getLastMessageId(),
            'text' => $text,
            'reply_markup' => $this->discountTypesKeyboard(),
        ]);
        $this->updateLastRequestId($r->messageId);
    }

    public function discountTypesKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()
            ->inline();
        \App\Models\ScoreCategory::where('is_active', true)
            ->each(function ($item) use ($keyboard) {
                $b = Keyboard::inlineButton([
                    'text' => ($this->lang == 'fa' ? $item->name : $item->name_en)  . " - " . $item->require_score,
                    'callback_data' => 'useScoresStore' . $item->id,
                ]);
                $keyboard->row($b);
            });
        $b = Keyboard::inlineButton([
            'text' => __("Return"),
            'callback_data' => 'profile'
        ]);
        $keyboard = $keyboard->row($b);

        return $keyboard;
    }

    public function useScoresStore(Api $t, Update $u, Message|Collection|EditedMessage $m, $discountId): void
    {
        $this->useScores($discountId);
        $this->successMessage(s()->useScoreSuccess);
        $this->profileScoresRequest($t, $u, $m);
    }
}
