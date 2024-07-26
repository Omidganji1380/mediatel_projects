<?php

namespace App\Http\Controllers\Front\Panel\User;

use App\Http\Controllers\Controller;
use App\Models\Ad\Ad;
use App\Models\AdvertisementOrder;
use App\Models\GoogleLink;
use App\Models\Plan;
use App\Models\TelegramAd;
use App\Models\Ticket;
use App\Traits\Helper;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class UserPanelController extends Controller
{
    use Helper;

    public function frontPanelUserDashboard()
    {
        return view('front.pages.panel.user.dashboard.index');
    }

    public function frontPanelUserAdIndex()
    {
        return view('front.pages.panel.user.ads.index');
    }

    public function frontPanelUserAdEdit($id)
    {
        //return
        $ad = Ad::whereId($id)
            ->whereUserId(auth()->id())
            ->firstOrFail();

        return view('front.pages.panel.user.ads.edit', compact('ad'));
    }

    public function frontPanelUserAdPayment($id)
    {
        $ad = Ad::whereId($id)
            ->whereUserId(auth()->id())
            ->firstOrFail();

        return view('front.pages.panel.user.ads.payment', compact('ad'));
    }

    public function frontPanelUserFavoriteIndex()
    {
        return view('front.pages.panel.user.favorites.index');
    }

    public function frontPanelUserPaymentIndex()
    {
        return view('front.pages.panel.user.payments.index');
    }

    public function frontPanelUserProfileEdit()
    {
        return view('front.pages.panel.user.profile.edit');
    }

    public function frontPanelUserProfileShow()
    {
        $user = Auth::user()->loadSum(['scores' => function ($query) {
            $query->where('spent', false)->where('claimed', true);
        }], 'score');
        $registrationProgress = $this->calculateRegistrationProgress();
        return view('front.pages.panel.user.profile.show', compact('user', 'registrationProgress'));
    }

    public function frontPanelPlans(Ad $ad)
    {
        return view('front.pages.panel.user.plans.index', compact('ad'));
    }

    public function frontPanelVipPlans()
    {
        return view('front.pages.panel.user.plans.vip');
    }

    public function frontPanelPinAdPlans(Ad $ad)
    {
        return view('front.pages.panel.user.plans.pin-ads', compact('ad'));
    }

    public function frontPanelTicketsIndex()
    {

        return view('front.pages.panel.user.tickets.index');
    }

    public function frontPanelTicketsCreate()
    {
        return view('front.pages.panel.user.tickets.create');
    }

    public function frontPanelTicketsShow($ticket_id)
    {
        return view('front.pages.panel.user.tickets.show', compact('ticket_id'));
    }

    public function adOrders()
    {
        return view('front.pages.panel.user.advertisements.index');
    }

    public function adOrdersShow(AdvertisementOrder $adOrder)
    {
        $advertisementOrder = $adOrder->load('advertisementType');
        return view('front.pages.panel.user.advertisements.show', compact('advertisementOrder'));
    }

    public function chat()
    {
        return view('front.pages.panel.user.chat.index');
    }

    public function frontPanelUserVideos()
    {
        return view('front.pages.panel.user.videos.index');
    }

    public function frontPanelUserScores()
    {
        return view('front.pages.panel.user.scores.index');
    }

    public function frontPanelUserUpgrade()
    {
        return view('front.pages.panel.user.upgrade.index');
    }

    public function frontPanelUserGoogleReview()
    {
        $links = GoogleLink::latest()->paginate();
        return view('front.pages.panel.user.google-review.index', compact('links'));
    }

    public function frontPanelServiceUsage()
    {
        return view('front.pages.panel.user.service-usage.index');
    }

    public function frontPanelTelegramAdPlans(TelegramAd $telegramAd)
    {
        return view('front.pages.panel.user.plans.telegram-ads', compact('telegramAd'));
    }
}
