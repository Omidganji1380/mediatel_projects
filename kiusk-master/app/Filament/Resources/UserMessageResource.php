<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserMessageResource\Pages;
use App\Filament\Resources\UserMessageResource\RelationManagers;
use App\Models\User;
use App\Models\UserMessage;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class UserMessageResource extends Resource
{
    protected static ?string $model = UserMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'پیام ';

    protected static ?string $navigationLabel = 'پیام ها ';

    protected static ?string $pluralLabel = 'پیام ها ';

    protected static ?string $navigationGroup = 'پیام ها ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('title')->label(__('Title')),
                    RichEditor::make('message')
                        ->label(__('Message'))
                        ->columnSpan([
                            'sm' => 2,
                        ]),
                ]),
                Card::make()->schema([
                    SpatieMediaLibraryFileUpload::make('image')
                    ->label(__('admin.image'))
                    ->collection('image'),
                ]),
                Card::make()->schema([
                    Checkbox::make('all')->label(__('All Users')),
                    Checkbox::make('business_owner')->label(__('messages.roles.business_owner')),
                    Checkbox::make('seller')->label(__('messages.roles.seller')),
                    Checkbox::make('real_estate')->label(__('messages.roles.real_estate')),
                    Checkbox::make('property_applicant')->label(__('messages.roles.property_applicant')),
                    Select::make('selected_user')
                        ->label(__('Select a user'))
                        ->multiple()
                        ->options(User::select(DB::raw("IFNULL(NULLIF(name, ''), email) AS display_value"), 'id')
                        ->where('telegram_id', '!=', null)
                        ->pluck('display_value', 'id'))
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label(__('Title')),
                BooleanColumn::make('all')
                    ->label(__('All Users'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('business_owner')
                    ->label(__('messages.roles.business_owner'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('seller')
                    ->label(__('messages.roles.seller'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('real_estate')
                    ->label(__('messages.roles.real_estate'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('property_applicant')
                    ->label(__('messages.roles.property_applicant'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserMessages::route('/'),
            'create' => Pages\CreateUserMessage::route('/create'),
            'edit' => Pages\EditUserMessage::route('/{record}/edit'),
        ];
    }
}
