<?php

namespace App\Mail\Admins;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $users;
    public $ads;
    public $orders;
    public $filePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users, $ads, $orders, $filePath)
    {
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->users = $users;
        $this->ads = $ads;
        $this->orders = $orders;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kiusk')
            ->subject(__('Daily Reports'))
            ->attach($this->filePath, ['as' => 'users.xlsx'])
            ->markdown('emails.admins.daily-reports');
    }
}
