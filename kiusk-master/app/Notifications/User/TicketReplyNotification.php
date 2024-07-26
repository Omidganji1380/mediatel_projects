<?php

namespace App\Notifications\User;

use App\Mail\User\RepliedTicketMail;
use App\Models\Ticket;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class TicketReplyNotification extends Notification
{
    use Queueable;

    public $ticket;
    public $message;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->ticket = $ticket;
        $lang = $ticket->user->lang === 'en' ? 'en' : '';
        $langRoute = $ticket->user->lang === 'en' ? 'en.' : '';
        $this->url = route($langRoute . 'front.panel.user.tickets.show', $ticket);
        $message = __('notifications.ticket_body');
        $message .= "\n" . route($langRoute . 'front.panel.user.tickets.show', $ticket);
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new RepliedTicketMail(
            $notifiable,
            route('front.panel.user.tickets.show', $this->ticket->id),
            __('View Ticket')
            ))
            ->to($notifiable->email);
                    // ->line(__('notifications.dear_user', ['name' => $notifiable->full_name]))
                    // ->line(__('notifications.ticket_body'))
                    // ->action(__('Ticket Link'), url($this->url))
                    // ->line(__('notifications.ending_thanks'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
