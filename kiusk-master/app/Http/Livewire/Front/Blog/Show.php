<?php

namespace App\Http\Livewire\Front\Blog;

use App\Http\Livewire\Front\Ad\RatingAd;
use App\Models\Advertisement;
use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Show extends Component
{
    use RatingAd;

    public Post $post;
    public $content;
    public $description;
    public $name;
    public $email;
    public $site;
    public $lang;
    public $comments;
    protected $rules = [
        'content' => 'required|string|max:99999',
        // 'content' => 'required|unique:blog_comments,content',
        'name' => 'required|string',
        'email' => 'email|required',
        'site' => 'nullable|url',
    ];
    // protected $validationAttributes = [
    //  'comment.content' => 'متن',
    // ];
    protected $listeners = [
        'viewed',
    ];

    public function mount()
    {
        $this->lang = App::isLocale('fa') ? '' : 'en.';
        Auth::check() ? $this->email = auth()->user()->email : '';
        Auth::check() ? $this->name = auth()->user()->name ?: '' : '';
        $this->ratingable = $this->post;
        $this->comments = $this->post?->comments;
        $this->mountRating();
    }

    public function render()
    {
        $this->description = $this->post->locale_content ? $this->addTableOfContentsToPostDescription($this->post->locale_content) : null;
        $this->addAdvertisementToDescription();
        // dd($this->description);
        return view('livewire.front.blog.show');
    }

    public function viewed()
    {
        DB::table($this->post->getTable())
            ->where('id', $this->post->id)
            ->update(['views' => $this->post->views + 1]);
    }

    public function storeComment()
    {
        if (Auth::check()) {
            // User is logged in, save their rating
            $this->saveComment();
        } else {
            // User is not logged in, redirect to login page
            return redirect()->route('login');
        }
    }

    public function saveComment()
    {
        $this->validate();
        if (auth()->user()->complete_profile) {
            $comment = Comment::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->first();
            if ($comment) {
                $this->swal('error', __("messages.comment_limit_error"));
                $this->reset('content');
            } else {
                $this->post->comments()
                    ->create([
                        'user_id' => Auth::id(),
                        'is_visible' => false,
                        'content' => $this->content,
                    ]);
                $this->swal('success', __("Your view was successfully submitted."));
                $this->reset('content');
            }
        } else {
            $this->swal('error', __('messages.commet_complete_profile_error'));
            return redirect()->route($this->lang . 'front.panel.user.profile.edit');
        }
    }

    public function swal($icon, $title)
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => $icon,
            'title' => $title,
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
        ]);
    }

    public function addTableOfContentsToPostDescription(string $description)
    {
        preg_match_all('|<\s*h[1-6](?:.*)>(.*)</\s*h|Ui', $description, $headings);
        if (count($headings[0])) {
            if (count($headings[1]) ===  count($headings[0])) {
                $headings = array_combine($headings[1], $headings[0]);
                $newHeadings = [];
                $ids = [];
                foreach ($headings as $headingText => $headingTag) {
                    $sluggedHeadingText = Str::slug($headingText);
                    $ids[$sluggedHeadingText] = $headingText;
                    if (preg_match("/id=[\"][^\"]{2,}[\"]/", $headingTag)) {
                        $newHead = preg_replace("/id=[\"][^\"]{2,}[\"]/", "id=\"$sluggedHeadingText\"", $headingTag);
                    } else {
                        $newHead = $this->addIdAttribute($sluggedHeadingText, $headingTag);
                    }
                    $newHeadings[$headingTag] = $newHead;
                }
            }
            $links = '
                <div class="border mb-4 p-2">
                    <h5 class="p-2">' . __('Table of Contents') . '</h5>
                    <ul class="list-group list-group-flush">';

            foreach ($ids as $id => $text) {
                $links .= '<li class="list-group-item border-0"><a href="#' . $id .  '">' . $text . '</a></li>';
            }

            $links .= '</ul></div>';

            foreach ($newHeadings as $original => $newHeading) {

                $description = Str::replace($original, $newHeading, $description);
            }
            return $links . $description;
        }
        return $description;
    }

    public function addIdAttribute($headingText, $headingTag)
    {
        return substr_replace($headingTag, " id=\"$headingText\"", 3, 0);
    }

    public function addAdvertisementToDescription()
    {
        // Retrieve all the images from the Advertisement model

        // Select a random image

        // Insert the image into the HTML text in the description of the post
        $description = $this->description;

        $ads = Advertisement::inRandomOrder()
            ->whereHas('adOrder')
            ->active()
            ->get();

        // Split the description into paragraphs
        $paragraphs = preg_split('/(<\/p>\s*<p[^>]*>)/', $description, -1, PREG_SPLIT_DELIM_CAPTURE);

        $paragraphCount = count($paragraphs);
        $j = 0;
        for ($i = 0; $i < $paragraphCount; $i++) {
            if (($i + 1) % 5 == 0) {
                if(isset($ads[$j]) && $ads[$j]->adOrder?->getFirstMediaUrl('BlogTextFa')){
                    $paragraphs[$i] .= '<div><script src="https://web.adminbot.ca/ads/canada-ads.js?version=1.0" data-uid="eF85NjUfCt0KdEnz" data-type="wide"></script></div>';
                    // $paragraphs[$i] .= '<script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="c11v2Y7oV7roSMVv"></script>';
                    // $paragraphs[$i] .= "<img class=\"w-100\" src='" . $ads[$j++]->adOrder?->getFirstMediaUrl(App::isLocale('fa') ? 'BlogTextFa' : 'BlogTextEn') . "'>";
                }
            }
        }

        // Combine the paragraphs back into a single string
        $descriptionWithImage = implode('', $paragraphs);

        // Update the post's description with the new HTML text
        $this->description = $descriptionWithImage;
    }
}
