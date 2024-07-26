<?php

namespace App\Mail\Admins;

use App\Models\Ad\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatedAdEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $admins;
    protected $ad;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admins, Ad $ad)
    {
        $this->admins = $admins;
        $this->ad = $ad;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $adminEmails = $this->admins->pluck('email')->toArray();
        $query = Ad::query();

        $totalCount = $query->count();

        $catAd = clone $query;

        $catAdCount = $catAd->whereHas('mainCategory', function ($query) {
            $query->where('type', $this->ad->mainCategory?->first()?->type);
        })
        ->count();
        $totalAdsCount = Ad::count();
        $adNumber = $totalAdsCount . '-' . $catAdCount . '-' . __('messages.categories.types.' . $this->ad->mainCategory?->first()?->type);
        return $this->subject('New Ad Created')
                ->to($adminEmails)
                ->markdown('emails.admins.created_ad', [
                    'ad' => $this->ad,
                    'adNumber' => $adNumber,
                ]);
    }
}
