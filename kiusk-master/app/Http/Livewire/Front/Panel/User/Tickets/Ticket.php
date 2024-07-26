<?php

namespace App\Http\Livewire\Front\Panel\User\Tickets;

use App\Models\Ticket as ModelsTicket;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Ticket extends Component
{
    public $lang;

    public function render()
    {
        $this->lang = App::isLocale('fa') ? "" : "en.";
        $tickets = ModelsTicket::whereBelongsTo(Auth::user())->whereIsRoot()->with('category')->latest()->paginate();
        return view('livewire.front.panel.user.tickets.ticket', compact('tickets'));
    }
}
