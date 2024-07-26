<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\Tickets\TicketResource;
use App\Models\Ticket;
use App\Notifications\User\TicketReplyNotification;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Pages\Page;
use Filament\Resources\Form;
use Illuminate\Database\Eloquent\Builder;

class ReplyTicket extends Page
{
    use \Filament\Resources\Pages\Concerns\InteractsWithRecord;

    protected static string $resource = TicketResource::class;

    protected static string $view = 'filament.resources.ticket-resource.pages.reply-ticket';

    protected static ?string $navigationLabel = 'پاسخ تیکت';

    protected static ?string $label = 'پاسخ تیکت';

    public $message = "";
    public $parentTickets;
    public $record;
    public $parent;

    public static function getModelLabel(): string
    {
        dd('sadfawsfed');
        // return __('Ticket');
    }

    public static function getEloquentQuery(): Builder
    {
        dd(parent::getEloquentQuery());
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public function mount($record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->parentTickets = Ticket::descendantsAndSelf($this->record->id);


        // $this->fillForm();

        // $this->previousUrl = url()->previous();
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()->schema([
                RichEditor::make('message')->label(__('Message'))
            ])
        ];
    }

    public function reply()
    {
        $ticket = Ticket::create([
            'user_id' => $this->record->user_id,
            'ticket_category_id' => $this->record->ticket_category_id,
            'title' => $this->record->title,
            'message' => $this->message,
            'status' => 'replied'
        ]);

        $this->record->appendNode($ticket);
        $this->record->update(['status' => 'replied']);
        $root = $this->parentTickets->first();
        $root->user->notify(new TicketReplyNotification($root));
        $this->message = "";
        $this->notify('success', __('Replied successfully'));

        return redirect()->to($this->getResource()::getUrl('index'));
    }
}
