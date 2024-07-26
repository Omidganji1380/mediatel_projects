<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScoreNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $score;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, int $score, string $type)
    {
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->user = $user;
        $this->score = $score;
        $this->type = __('messages.scores.types.' . $type);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kiusk')->markdown('emails.score-notification');
    }
}
