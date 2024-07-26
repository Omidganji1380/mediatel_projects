<?php

namespace App\Http\Livewire\Front\Panel\User\Tickets;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $ticket;
    public $ticket_id;
    public $parent;
    public $ticketCategoryId;
    public $title;
    public $message;

    public function mount($ticket_id)
    {
        $this->ticket_id = $ticket_id;
    }

    public function render()
    {
        $this->ticket = Ticket::find($this->ticket_id);
        $ticket = $this->ticket->load('descendants');
        $this->parent = Ticket::descendantsAndSelf($ticket->id)->last();
        return view('livewire.front.panel.user.tickets.show', compact('ticket'))->layout('front.pages.panel.user.base');
    }

    public function reply()
    {
        Ticket::create([
            'title' => $this->ticket->title,
            'ticket_category_id' => $this->ticket->ticket_category_id,
            'message' => $this->message,
            'user_id' => Auth::id(),
            'status' => 'pending',
            'parent_id' => $this->parent->id
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'تیکت با موفقیت ثبت شد.',
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> متوجه شدم',
            'width' => 300,
           ]);

        return redirect()->to(route('front.panel.user.tickets.index'));
    }
}
