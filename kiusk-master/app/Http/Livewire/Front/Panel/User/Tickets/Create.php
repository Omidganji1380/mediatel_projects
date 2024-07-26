<?php

namespace App\Http\Livewire\Front\Panel\User\Tickets;

use App\Mail\User\CreatedTicketMail;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Swift_TransportException;

class Create extends Component
{
    public $ticketCategoryId;
    public $title;
    public $message;

    protected $rules = [
        'title' => 'required|string',
        'ticketCategoryId' => 'required|integer|exists:ticket_categories,id',
        'message' => 'required|string|min:10',
    ];

    public function render()
    {
        return view('livewire.front.panel.user.tickets.create');
    }

    public function store()
    {
        Ticket::create([
            'title' => $this->title,
            'ticket_category_id' => $this->ticketCategoryId,
            'message' => $this->message,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'تیکت با موفقیت ثبت شد.',
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> متوجه شدم',
            'width' => 300,
        ]);

        $user = Auth::user();

        try {
            Mail::to($user->email)->send(new CreatedTicketMail($user));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }


        return redirect()->to(route('front.panel.user.tickets.index'));
    }
}
