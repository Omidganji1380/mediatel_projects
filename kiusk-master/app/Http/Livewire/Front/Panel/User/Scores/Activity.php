<?php

namespace App\Http\Livewire\Front\Panel\User\Scores;

use App\Models\Ad\Ad;
use App\Models\Blog\Post;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Activity extends Component
{
    public $lang;

    public function render()
    {
        $this->lang = auth()->user()->lang == "fa" ? "" : "en.";
        return view('livewire.front.panel.user.scores.activity');
    }

    public function goToActivity($type)
    {
        $url = "/";
        $ad = Ad::isVisible()->isFeatured()->inRandomOrder()->first();
        $post = Post::isVisible()->inRandomOrder()->first();

        switch ($type) {
            case 'rate':
                $url = $ad ? route($this->lang . 'front.home') : route($this->lang . 'front.home');
                break;
            case 'review':
                $url = $ad ? route($this->lang . 'front.home') : route($this->lang . 'front.home');
                break;
            case 'comment':
                $url = $post ? route($this->lang . 'front.blog.category.blog.index.first.page') : route($this->lang . 'front.blog.category.blog.index.first.page');
                break;
            case 'complete_registration':
                $url = route($this->lang . 'front.panel.user.profile.edit') . "#user-information";
                break;
            case 'referral':
                $url = route($this->lang . 'front.panel.user.profile.edit') . "#user-referral";
                break;
            case 'google_review':
                $url = route($this->lang . 'front.panel.user.google-review.index');
                break;
            case 'send_video':
                $url = route($this->lang .'front.panel.user.videos.index');
                break;
            case 'service_usage':
                $url = route($this->lang . 'front.panel.user.service-usage.index');
                break;

            default:
                $url = "/";
                break;
        }

        return redirect()->to($url);
    }
}
