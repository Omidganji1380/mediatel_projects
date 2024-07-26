<?php

namespace App\Filament\Resources\Ad\AdResource\Pages;

use App\Filament\Resources\Ad\AdResource;
use App\Jobs\SitemapGenerateJob;
use App\Mail\Admins\AdminAdApprovedMail;
use App\Mail\Admins\AdminAdRejectedMail;
use App\Mail\User\AdPublishedMail;
use App\Mail\User\AdRejectedMail;
use App\Models\Ad\Ad;
use App\Notifications\User\StatusNotification;
use App\Rules\Seo;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Swift_TransportException;

class EditAd extends EditRecord
{
    protected static string $resource = AdResource::class;

    protected function getActions(): array
    {
        return array_merge(parent::getActions(), [
            ButtonAction::make(__('admin.toTop'))
                ->action('toTop'),
            ButtonAction::make(__('admin.show'))
                ->openUrlInNewTab()
                ->url(route('front.ad.show', $this->record)),
        ]);
    }

    public function toTop(): void
    {
        /**
         * @var Ad $ad
         * */
        $ad = $this->record;
        $ad->moveToEnd();
        $this->notify('success', __('admin.toTopDone'));
    }

    protected function beforeValidate(): void
    {
        //  $this->seoEditPageBeforeValidate();
        $this->data['slug'] = Str::slug(($this->data['slug']  != "") ? $this->data['slug'] : $this->data['title_en']);
        $record = $this->record;
        /**
         * @var Ad $record
         * */
        $record->update(['created_at' => $this->data['created_at']]);
    }

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $data['slug'] = Str::slug($data['slug'] ?: $data['title_en']);

    //     return $data;
    // }

    protected function afterSave(): void
    {
        $this->record->logs()->create([
            'created_by' => $this->record->user_id,
            'updated_by' => Auth::id(),
        ]);

        if($this->data['message']){
            // The Ad has been denied with a note to send to the user
            if(!$this->record->is_visible){
                // Send a mail to user with the message why it had been rejected
                try {
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
                    Mail::to('memoney026@gmail.com')->send(new AdminAdRejectedMail(
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
                Mail::to($this->record->user->email)->send(new AdPublishedMail(
                    $this->record->user,
                    __('messages.ads.approved'),
                    route('front.ad.show', $this->record->slug),
                    __('View Ad')
                ));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }

            try {
                Mail::to('Kiusk.ca@yahoo.com')->send(new AdminAdApprovedMail(
                    $this->record,
                    Auth::user(),
                    $this->data['message'],
                    route('front.panel.user.ad.edit', $this->record->id),
                    __('Ad')
                ));
                Mail::to('memoney026@gmail.com')->send(new AdminAdApprovedMail(
                    $this->record,
                    Auth::user(),
                    $this->data['message'],
                    route('front.panel.user.ad.edit', $this->record->id),
                    __('Ad')
                ));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }
        }
    }

    // public function updatedData($value, $key)
    // {
    //     $this->seoEditPageBeforeValidate();
    // }

    public function seoEditPageBeforeValidate(): void
    {
        $this->validate([
            'data.seo_description' => new Seo($this->data['title'], 'des'),
            'data.seo_title' => new Seo($this->data['title'])
        ]);
    }
}
