<?php

namespace App\Filament\Resources\Ad\RealEstateResource\Pages;

use App\Filament\Resources\Ad\RealEstateResource;
use App\Jobs\SitemapGenerateJob;
use App\Mail\Admins\AdminAdApprovedMail;
use App\Mail\Admins\AdminAdRejectedMail;
use App\Mail\User\AdPublishedMail;
use App\Mail\User\AdRejectedMail;
use App\Mail\User\PropertyApplicantMail;
use App\Notifications\User\StatusNotification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class EditRealEstate extends EditRecord
{
    protected static string $resource = RealEstateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->record->logs()->create([
            'created_by' => $this->record->user_id,
            'updated_by' => Auth::id(),
        ]);

        if($this->data['message']){
            // The Ad has been denied with a note to send to the user
            if(!$this->record->is_visible){
                try {
                   // Send a mail to user with the message why it had been rejected
                    Mail::to($this->record->user->email)->send(new AdRejectedMail(
                        $this->record->user,
                        $this->data['message'],
                        route('front.panel.user.ad.edit', $this->record->id),
                        __('Edit Ad')
                    ));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }

                try {
                    // Send a mail to Super admin who and why it had been rejected
                    Mail::to('Kiusk.ca@yahoo.com')->send(new AdminAdRejectedMail(
                        $this->record,
                        Auth::user(),
                        $this->data['message'],
                        route('front.panel.user.ad.edit', $this->record->id),
                        __('Ad')
                    ));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }
            }else{
                $this->record->user?->notify(new StatusNotification($this->data['message']));
            }
        }

        // If the ad approved and is active is dirty , if the user purchased a plan for this ad
        // and the plan has pin ad , should dispatch the PinAdEvent to pin this add
        // you have to make sure it happens only once
        if($this->record->wasChanged('is_visible') && $this->record->is_visible && $this->record->status !== 'approved'){
            $this->record->setStatus('approved');
            // Generate sitemap on approve ad
            SitemapGenerateJob::dispatch();
            // $this->record->user?->notify(new StatusNotification(__('messages.ads.approved')));

            try {
                // Send a mail to Super admin who and why it had been rejected
                Mail::to($this->record->user->email)->send(new AdPublishedMail(
                    $this->record->user,
                    __('messages.ads.approved'),
                    route('front.ad.show', $this->record->slug),
                    __('View Ad')
                ));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }


            // Notify Vip Users
            if($this->record->is_property_applicant){
                $users = \App\Models\User::whereHas('vipSubscription', function ($query) {
                    $query->where('is_active', true);
                })->get();
                foreach($users as $user){
                    try {
                        Mail::to($user->email)->queue(new PropertyApplicantMail($user, $this->record));
                    } catch (Swift_TransportException $exception) {
                        Log::error('Error sending email: ' . $exception->getMessage());
                    }
                }
            }

            try {
                Mail::to('Kiusk.ca@yahoo.com')->send(new AdminAdApprovedMail(
                    $this->record,
                    Auth::user(),
                    $this->data['message'] ?? null,
                    route('front.panel.user.ad.edit', $this->record->id),
                    __('Ad')
                ));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }
        }
    }
}
