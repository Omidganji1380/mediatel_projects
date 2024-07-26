<?php

namespace App\Http\Livewire\Front\Panel\User\Scores;

use App\Mail\User\CreatedDiscountMail;
use App\Models\Discount;
use App\Models\ScoreCategory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Swift_TransportException;

trait Usage
{
    public $score;
    public $type;
    public $discountCode;
    public $link;

    public function usage()
    {
        $user = $this->user->loadSum(['scores' => function ($query) {
            $query->where('spent', false)->where('claimed', true);
        }], 'score');
        $type = ScoreCategory::findOrFail($this->type);
        $this->validate([
            'type' => 'required|exists:score_categories,id',
        ]);
        if((int)$type->require_score > ($user->scores_sum_score ?? 0)){
            $this->addError('type' , __('messages.scores.limit_error'));
        }else{
            $this->createDiscount();
            $this->calculateScoreUsage($user, (int)$type->require_score);
            $this->loadUser();
        }
    }

    public function createDiscount()
    {
        $this->discountCode = $this->generateUniqueDiscountCode(auth()->id());
        $type = ScoreCategory::findOrFail($this->type);
        $response = Http::post('http://mediatel.ca/wp-json/mediatell/v1/getDiscount', [
            'code' => $this->discountCode,
            'email' => auth()->user()->email,
            'drscription' => $type->name
        ]);
        if($response->status() == 200){
            $this->link = $response->collect()->first();
            Discount::create([
                'code' => $this->discountCode,
                'user_id' => auth()->id(),
                'score_category_id' => $this->type,
                'url' => $response->collect()->first(),
            ]);
            try {
                Mail::to(auth()->user()->email)->send(new CreatedDiscountMail(auth()->user()));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }

        }else{
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'error',
                'title' => __('messages.something_went_wrong'),
                'timerProgressBar' => true,
                'timer' => 20000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300,
            ]);
        }
    }
}
