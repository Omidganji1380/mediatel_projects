<?php

namespace App\Http\Livewire\Front\Panel\User\Scores;

use Livewire\Component;

class Descriptions extends Component
{
    public function render()
    {
        return view('livewire.front.panel.user.scores.descriptions');
    }

    public function getDescription($type) : void
    {
        $html = s()->scoresText[$type]['description'] ?? "";

        $this->dispatchBrowserEvent('swal:modal', [
            'title' => __('messages.scores.types.'. $type),
            'timerProgressBar' => true,
            'timer' => 90000,
            'html' => $html,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 900,
        ]);
        $this->dispatchBrowserEvent('removeHrefLinkAttr', ['item' => 'javascript:void(0)']);
    }
}
