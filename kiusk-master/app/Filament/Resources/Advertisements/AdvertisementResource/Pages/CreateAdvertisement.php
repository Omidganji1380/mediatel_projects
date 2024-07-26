<?php

namespace App\Filament\Resources\Advertisements\AdvertisementResource\Pages;

use App\Filament\Resources\Advertisements\AdvertisementResource;
use App\Jobs\ExpireAdvertisementJob;
use App\Mail\Admins\ApprovedAdvertisementMail as AdminsApprovedAdvertisementMail;
use App\Mail\Admins\RejectAdvertisementMail as AdminsRejectAdvertisementMail;
use App\Mail\ApprovedAdvertisementMail;
use App\Mail\RejectAdvertisementMail;
use App\Models\Advertisement;
use App\Models\AdvertisementOrder;
use App\Notifications\User\StatusNotification;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Swift_TransportException;

class CreateAdvertisement extends CreateRecord
{
    protected static string $resource = AdvertisementResource::class;

    protected $queryString = ['advertisementOrder'];

    public $adOrder;
    public $advertisementOrder;

    public function mount(): void
    {
        $this->adOrder = AdvertisementOrder::find($this->advertisementOrder);
        $this->form->fill([
            'position' => $this->adOrder?->advertisementType?->position,
            'status' => 'published',
            'description_fa' => $this->adOrder?->description_fa,
            'description_en' => $this->adOrder?->description_en,
            'advertisement_type_id' => $this->adOrder?->advertisement_type_id,
            'link' => $this->adOrder?->url,
        ]);
    }

    protected function handleRecordCreation(array $data): Model
    {
        return static::getModel()::create($data);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['advertisement_type_id'] = $this->adOrder->advertisement_type_id;
        $data['advertisement_order_id'] = $this->adOrder->id;
        $data['user_id'] = $this->adOrder?->user_id ?? Auth::id();
        $data['days'] = $this->adOrder?->days ?? 0;
        $data['title'] = $this->adOrder?->title ?? 0;
        $data['title_en'] = $this->adOrder?->title_en ?? 0;
        $data['description_fa'] = $this->adOrder?->description_fa ?? 0;
        $data['description_en'] = $this->adOrder?->description_en ?? 0;
        $data['position'] = 'main_page';
        return $data;
    }

    public function createButtonLabel()
    {
        return __('Confirm');
    }

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     dd('test');

    //     return $data;
    // }

    protected function afterCreate(): void
    {
        $this->record->logs()->create([
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        if ($this->data['message']) {
            // The Ad has been denied with a note to send to the user
            if (!$this->record->active) {
                // Send a mail to user with the message why it had been rejected
                try {
                    Mail::to($this->record->user->email)->queue(new RejectAdvertisementMail(
                        $this->record?->adOrder?->user,
                        $this->data['message'],
                        route('front.panel.user.ad-orders.show', $this->record->id),
                        __('Edit Ad')
                    ));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }


                // Send a mail to Super admin who and why it had been rejected
                try {
                    Mail::to('Kiusk.ca@yahoo.com')->queue(new AdminsRejectAdvertisementMail(
                        $this->record,
                        Auth::user(),
                        $this->data['message'],
                        route('front.panel.user.ad.edit', $this->record->id),
                        __('Ad')
                    ));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }
            } else {
                $this->record->adOrder?->user?->notify(new StatusNotification($this->data['message']));
            }
        }

        // If the ad approved and is active is dirty , if the user purchased a plan for this ad
        // and the plan has pin ad , should dispatch the PinAdEvent to pin this add
        // you have to make sure it happens only once
        if ($this->record->wasChanged('active') && $this->record->active && $this->record->status !== 'approved') {
            $this->record->setStatus('approved');
            ExpireAdvertisementJob::dispatch($this->record)
                ->delay(now()->addDays($this->record->days));
            // $this->record->user?->notify(new StatusNotification(__('messages.ads.approved')));
            try {
                Mail::to($this->record->user->email)->queue(new ApprovedAdvertisementMail(
                    $this->record->user,
                    __('emails.messages.advertisements.approved'),
                    route('front.ad.show', $this->record->slug),
                    __('View Ad')
                ));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }

            try {
                Mail::to('Kiusk.ca@yahoo.com')->queue(new AdminsApprovedAdvertisementMail(
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
}
