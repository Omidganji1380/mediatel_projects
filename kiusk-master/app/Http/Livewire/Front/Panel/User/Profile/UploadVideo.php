<?php

namespace App\Http\Livewire\Front\Panel\User\Profile;

use App\Models\UserVideo;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadVideo extends Component
{
    use WithFileUploads;

    public $previewVideo;
    public $videos;
    public $video;

    public function mount()
    {
        $this->videos = UserVideo::whereBelongsTo(auth()->user())->get();
    }

    public function render()
    {
        return view('livewire.front.panel.user.profile.upload-video');
    }

    public function upload()
    {
        $this->validate([
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:20480',
        ]);
        $user = auth()->user();

        $userVideo = UserVideo::create([
            'user_id' => auth()->id()
        ]);

        $media = $userVideo->addMedia($this->video)
            ->toMediaCollection('video');
        // $this->previewVideo = $media->getUrl('videos');
        $this->videos = UserVideo::whereBelongsTo(auth()->user())->get();
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.upload_video_success'),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300
        ]);
    }
}
