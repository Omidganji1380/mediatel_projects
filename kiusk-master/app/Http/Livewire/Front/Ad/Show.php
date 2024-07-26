<?php

namespace App\Http\Livewire\Front\Ad;

use App\Http\Livewire\Front\Ad\Show\ClickCount;
use App\Mail\User\AdReviewMail;
use App\Models\Ad\Ad;
use App\Models\Ad\Review;
use App\Models\User;
use App\Traits\BlogTrait;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Swift_TransportException;

class Show extends Component
{
    use Favorite, BlogTrait, RatingAd, ClickCount;

    public Ad $ad;
    public $lang;
    public string $email = '';
    public string $name = '';
    public string $comment = '';
    public $comments;

    protected $rules = [
        'email' => 'required|email',
        'name' => 'required|min:3',
        'comment' => 'required',
    ];
    // protected $validationAttributes = [
    //     'email' => 'ایمیل',
    //     'name' => 'نام',
    //     'comment' => 'دیدگاه',
    // ];
    protected $listeners = [
        'reportConfirm',
        'viewed',
    ];
    public $currentUrl;

    public function mount()
    {
        $this->lang = App::isLocale('fa') ? '' : 'en.';
        $this->ratingable = $this->ad;
        $this->comments = $this->ad?->reviews;
        Auth::check() ? $this->email = auth()->user()->email : '';
        Auth::check() ? $this->name = auth()->user()->name ?: '' : '';
        $this->ad = $this->ad->load(['city', 'mainCategory', 'media']);
        $this->mountFavorite();
        $this->mountRating();
    }

    /**
     * Check if user logged in or not to leave comments
     *
     * @return void|Redirect
     */
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

    /**
     * Store the Comment in database and attach to the ad if user completed its profile
     *
     * @return void
     */
    public function saveComment()
    {
        $this->validate();
        if (auth()->user()->complete_profile) {
            $comment = Review::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->first();
            if ($comment) {
                $this->swal('error', __("messages.comment_limit_error"));
                $this->reset('comment');
            } else {
                $this->ad->reviews()
                    ->create([
                        'content' => $this->comment,
                        'user_id' => Auth::id(),
                    ]);
                $this->swal('success', __("Your view was successfully submitted."));
                $this->reset('comment');
                try {
                    Mail::to($this->ad->user->email)->send(new AdReviewMail($this->ad->user));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }
            }
        }else{
            $this->swal('error', __('messages.commet_complete_profile_error'));
            return redirect()->route($this->lang .'front.panel.user.profile.edit');
        }
    }

    public function formatPhone($phone)
    {
        if (preg_match('/^\+\d(\d{3})(\d{3})(\d{4})$/', $phone,  $matches) || preg_match('/(\d{3})(\d{3})(\d{4})$/', $phone,  $matches)) {
            $result = "($matches[1])" . ' ' . $matches[2] . ' ' . $matches[3];
            return $result;
        }
        return $phone;
    }

    public function showContactInfo()
    {
        $phone = $this->ad->phone !== '' && $this->ad->phone !== null ? $this->ad->phone : $this->ad?->user?->phone;
        $email = $this->ad->email !== '' && $this->ad->email !== null ? $this->ad->email : $this->ad?->user?->email;

        $formattedPhone = $this->formatPhone($phone);

        $html = "";
        if ($this->ad->is_visible_phone) {
            $html = __('Phone Number') . ":<br>";
            if ($this->ad->expired) {
                $html .= "<a href=\"tel:{$phone}\"><span class=\"arial-font\" dir=\"ltr\">{$formattedPhone}</span></a><br>";
            } else {
                $html .= "<p>" . __('This ad has expired.') . "</p>";
            }
        }

        if ($this->ad->is_visible_email) {
            //  if ((isset($this->ad->extra->showEmail) && $this->ad->extra->showEmail) || !isset($this->ad->extra->showEmail)) {
            if ($this->ad->expired) {
                $html .= __('Email') . ": <br><a href=\"mailto:{$email}\">{$email}</a>";
            } else {
                $html .= "<p>" . __('This ad has expired.') . "</p>";
            }
        }
        $this->dispatchBrowserEvent('swal:modal', [
            'title' => __('Contact Info'),
            'timerProgressBar' => true,
            'timer' => 20000,
            'html' => $html,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
        ]);
    }

    public function report()
    {
        $this->dispatchBrowserEvent('swal:confirm2', [
            'icon' => 'info',
            'title' => __('Select the reason for your report.'),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => __('Send'),
            'cancelButtonText' => __('Cancel'),
            'showCancelButton' => true,
            'width' => 600,
            'input' => 'select',
            'inputOptions' => [
                'Ad content is inappropriate.' => 'محتوای آگهی نامناسب است.',
                'The advertisement information is misleading or false.' => 'اطلاعات آگهی گمراه کننده یا دروغ است.',
                'The ad is spam and has been posted multiple times.' => ' آگهی اسپم است و چندین بار پست شده است.',
                'The ad is in the wrong category.' => 'آگهی در دسته بندی نامناسب قرار گرفته است.',
                'Goods or services are no longer available.' => ' خدمات کالا یا املاک دیگر موجود نیست.',
                'The goods or services included in the list of examples of criminal content.' => 'کالا یا خدمات قرار گرفته مشمول فهرست مصادیق محتوای مجرمانه می باشد.',
                'Other reasons...' => ' دلایل دیگر...',
            ],
            'event' => 'reportConfirm',
            'customClass' => [
                'input' => 'swal_input',
            ],
        ]);
    }

    public function reportConfirm($a)
    {
        if ($a['isConfirmed']) {
            $this->ad->reports()
                ->create([
                    'title' => $a['value'],
                    'user_id' => auth()->check() ? auth()->id() : null,
                ]);
            $this->dispatchBrowserEvent('swal:modal', [
                'icon' => 'success',
                'title' => __('Your report has been successfully submitted.'),
                'timerProgressBar' => true,
                'timer' => 20000,
                'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
                'width' => 300,
            ]);
        }
    }

    public function viewed()
    {
        FacadesDB::table($this->ad->getTable())
            ->where('id', $this->ad->id)
            ->update(['views' => $this->ad->views + 1]);
    }

    public function render()
    {
        $sidebar = $this->sidebar();
        return view('livewire.front.ad.show', compact('sidebar'));
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
}
