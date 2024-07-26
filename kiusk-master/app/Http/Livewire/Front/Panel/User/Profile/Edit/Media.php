<?php

namespace App\Http\Livewire\Front\Panel\User\Profile\Edit;

use App\Events\ProfileEvent;

trait Media
{
    public $avatar;
    public $previewAvatar;

    public function updatedAvatar($v)
    {
        $this->validate([
            'avatar' => 'image|max:1024',
        ]);
        $user = auth()->user();
        if ($user->getFirstMedia('profile')) {
            $user->getFirstMedia('profile')
                ->delete();
        }
        $media = $user->addMedia($this->avatar)
            ->toMediaCollection('profile');
        $this->previewAvatar = $media->getUrl('avatar');
        $user = $user->refresh();
        if($this->calculateRegistrationProgress($user) === 100){
            ProfileEvent::dispatch($this->user);
        }
        $this->notCompletedItems();
        $this->registrationProgress = $this->calculateRegistrationProgress();
        $this->dispatchBrowserEvent('progressUpdated');
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.profile.avatar_message'),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300
        ]);
    }

    public function mediaDelete()
    {
        auth()
            ->user()
            ->getFirstMedia('profile')
            ->delete();
        $this->reset('avatar', 'previewAvatar');
        $this->notCompletedItems();
        $this->registrationProgress = $this->calculateRegistrationProgress();
        $this->dispatchBrowserEvent('progressUpdated');
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.profile.avatar_delete_message'),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> متوجه شدم',
            'width' => 300
        ]);
    }
}
