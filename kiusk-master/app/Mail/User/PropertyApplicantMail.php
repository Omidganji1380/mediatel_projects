<?php

namespace App\Mail\User;

use App\Models\Ad\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class PropertyApplicantMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ad;
    public $link;
    public $btnText;
    public $color;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Ad $ad)
    {
        $lang = App::isLocal('fa') ? "" : "en.";
        $this->user = $user;
        $this->ad = $ad;
        $this->link = route($lang . 'front.ad.show', $ad->slug);
        $this->btnText = __('View Ad');
        $this->color = 'primary';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kiusk')->subject(__('New Property Applicant'))->markdown('emails.property-applicant');
    }
}
