<?php

namespace App\Mail\Admins;

use App\Models\Ad\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PinAdEmail extends Mailable
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
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
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
        return $this->subject('New Ad To be pinned')
                ->to($adminEmails)
                ->view('emails.admins.pin_ad', [
                    'ad' => $this->ad,
                ]);
    }
}
