<?php

namespace App\Jobs;

use App\Mail\UnreadMessageNotification;
use App\Models\ChMessage as Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class ProcessUnreadMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = Carbon::parse('2023-08-15');
        $users = User::whereNotNull('email')
            ->where('email', 'not like', '%@telegram.telegram%')
            ->whereDate('created_at', '>', $today)
            ->whereNotNull('email_verified_at')
            ->isActive()
            ->get();

        foreach ($users as $user) {
            $lastUnreadMessage = Message::where('to_id', $user->id)
                ->where('seen', false)
                ->latest('created_at')
                ->first();

            if ($lastUnreadMessage) {
                $lastUnreadMessageTime = Carbon::parse($lastUnreadMessage->created_at);
                $timeDifference = Carbon::now()->diffInMinutes($lastUnreadMessageTime);

                if ($timeDifference >= 10 && !$user->unread_message_notification_sent) {
                    // Send the notification
                    $unreadCount = Message::where('to_id', $user->id)
                        ->where('seen', false)
                        ->count();
                    try {
                        Mail::to($user)->queue(new UnreadMessageNotification($user, $unreadCount));

                        // Update the flag indicating the notification has been sent
                        $user->unread_message_notification_sent = true;
                        $user->save();
                    } catch (Swift_TransportException $exception) {
                        Log::error('Error sending email: ' . $exception->getMessage());
                    }

                }
            }else{
                $user->update(['unread_message_notification_sent' => false]);
            }
        }
    }
}
