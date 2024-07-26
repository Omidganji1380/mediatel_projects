<?php

namespace App\Http\Livewire\Front\Ad\Show;

use Livewire\Component;

class ContactInfo extends Component
{
    public $ad;

    public function render()
    {
        return view('livewire.front.ad.show.contact-info');
    }

    public function showContactInfo()
    {
        $phone = $this->ad->phone !== '' && $this->ad->phone !== null ? $this->ad->phone : $this->ad?->user->phone;
        $email = $this->ad->email !== '' && $this->ad->email !== null ? $this->ad->email : $this->ad?->user->email;
        $formattedPhone = $this->formatPhone($phone);
        $html = "";
        if ($this->ad->is_visible_phone) {
            $html = __('Phone Number') . ":<br>";
            $html .= "<a href=\"tel:{$phone}\"><span dir=\"ltr\" class=\"arial-font\">{$formattedPhone}</span></a><br>";
        }

        if ($this->ad->is_visible_email) {
            //  if ((isset($this->ad->extra->showEmail) && $this->ad->extra->showEmail) || !isset($this->ad->extra->showEmail)) {
            $html .= __('Email') . ": <br><a href=\"mailto:{$email}\">{$email}</a>";
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

    public function formatPhone($phone)
    {
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phone,  $matches ) || preg_match( '/(\d{3})(\d{3})(\d{4})$/', $phone,  $matches ) )
        {
            $result = "($matches[1])" . ' ' .$matches[2] . ' ' . $matches[3];
            return $result;
        }
        return $phone;
    }
}
