<?php

namespace App\Http\Livewire\Front\Panel\User\Ad;

use App\Events\PinAdEvent;
use App\Jobs\ExpirePromotedAd;
use App\Jobs\PromoteAd;
use App\Models\Ad\Ad;
use App\Traits\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\ResponseCache\Facades\ResponseCache;

class Index extends Component
{
    use Helper;

    public $lang;

    public function mount()
    {
        $this->lang = App::isLocale('fa') ? "" : "en.";
    }

    public function render()
    {
        return view('livewire.front.panel.user.ad.index');
    }

    protected $listeners = [
        'delete',
        'promoteConfirm'
    ];

    public function delete($event, $params)
    {
        if ($event['isConfirmed']) {
            Ad::whereUserId(auth()->id())
                ->whereId($params[0])
                ->delete();
            ResponseCache::clear();
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => __('messages.destroy', ['name' => __('Ad')]),
                'timerProgressBar' => true,
                'timer' => 20000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300,
            ]);

            return $this->redirect(route($this->lang . 'front.panel.user.ad.index'));
        }
    }

    public function beforeDelete($id)
    {
        $this->dispatchBrowserEvent('swal:confirm3', [
            'icon' => 'error',
            'title' => __('messages.ads.delete'),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => __("Delete"),
            'cancelButtonText' => __('Cancel'),
            'showCancelButton' => true,
            'width' => 300,
            'event' => 'delete',
            'params' => [$id],
        ]);
    }

    public function pinAd($id)
    {
        $ad = Ad::findOrFail($id);
        $user = Auth::user();
        if($ad->is_visible){
            if($user->subscriptions->count()){
                if($this->planHasPinAd($user->subscriptions) ){
                    PinAdEvent::dispatch($ad);
                    return $this->responseMessage('success', __('Your ad will be pinned on Kiusk\'s Telegram channel and Instagram page.'));
                }else{
                    return redirect()->to(route($this->lang . 'front.panel.user.plans.pin-ads', $ad->slug));
                }
            }else{
                return redirect()->to(route($this->lang . 'front.panel.user.plans.pin-ads', $ad->slug));
            }
        }else{
            $this->responseMessage("error", __('Your ad is waiting for approval. Please try again after confirming the ad.'));
        }
    }

    public function promote($id)
    {
        $ad = Ad::findOrFail($id);
        $user = Auth::user();
        if($ad->is_visible){
            if($this->isPlanVip($user->subscriptions)){
                if($user->vipSubscription?->featured_usage < $user->vipSubscription?->plan?->featured_limit){
                    $this->dispatchBrowserEvent('swal:confirm4', [
                        'icon' => 'info',
                        'title' => __('messages.ads.promote_confirm_title'),
                        'text' => __('messages.ads.promote_confirm_text'),
                        'timerProgressBar' => true,
                        'timer' => 20000,
                        'confirmButtonText' => __('Confirm'),
                        'cancelButtonText' => __('Cancel'),
                        'showCancelButton' => true,
                        'width' => 600,

                        'event' => 'promoteConfirm',
                        'customClass' => [
                            'input' => 'swal_input',
                        ],
                        'params' => [$id],
                    ]);
                }else{
                    $this->responseMessage('error', __('messages.ads.promote_limit_error'));
                    return redirect()->to(route($this->lang . 'front.panel.user.plans.index', ['ad' => $ad->slug, "model_type" => 'ad']));
                }
            }else{
                return redirect()->to(route($this->lang . 'front.panel.user.plans.index', ['ad' => $ad->slug, "model_type" => 'ad']));
            }
        }else{
            $this->responseMessage('error', __('Your ad is waiting for approval. Please try again after confirming the ad.'));
        }
    }

    public function promoteConfirm($event, $params){
        if ($event['isConfirmed']) {
            $ad = Ad::whereUserId(auth()->id())
                ->whereId($params[0])
                ->firstOrFail();
            $user = Auth::user();
            $plan = $user->vipSubscription?->plan;
            $end = $user->vipSubscription?->ends_at;
            $endDate = Carbon::parse($end);
            $daysDiff = Carbon::now()->diffInDays($endDate);
            $user->vipSubscription?->increment('featured_usage');
            PromoteAd::dispatch($ad, $plan);
            ExpirePromotedAd::dispatch($ad)->delay(now()->addDays($daysDiff));

            $this->responseMessage('suuccess', __('messages.ads.promote_success'));

            return $this->redirect(route($this->lang . 'front.panel.user.ad.index'));
        }
    }

    public function responseMessage($icon, $message)
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => $icon,
            'title' => $message,
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
        ]);
    }
}
