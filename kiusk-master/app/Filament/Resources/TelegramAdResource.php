<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TelegramAdResource\Pages;
use App\Filament\Resources\TelegramAdResource\RelationManagers;
use App\Models\TelegramAd;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TelegramAdResource extends Resource
{
    protected static ?string $model = TelegramAd::class;

    protected static ?string $label = 'تبلیغ تلگرام';

    protected static ?string $navigationLabel = 'تبلیغات تلگرام';

    protected static ?string $pluralLabel = 'تبلیغات تلگرام';

    protected static ?string $navigationGroup = 'تبلیغات ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Placeholder::make('user_id')
                        ->label(__('admin.user'))
                        ->content(fn (?TelegramAd $record): string => $record ? ($record->user->name_with_role ?? '-') : '-'),
                    Placeholder::make('category_id')
                        ->label(__('admin.category.name'))
                        ->content(fn (?TelegramAd $record): string => $record ? ($record->category?->locale_name ?? '-') : '-'),
                    Placeholder::make('category_id')
                        ->label(__('admin.category.type'))
                        ->content(fn (?TelegramAd $record): string => $record ? ($record->ad_type ? __('messages.categories.types.' . $record->ad_type) : '-') : '-'),
                    Placeholder::make('created_at')
                        ->label(__('admin.created_at'))
                        ->content(fn (?TelegramAd $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    TextInput::make('link')->label(__('Link')),
                    Textarea::make('description')->label(__('Persian Description'))->columnSpanFull(),
                    Textarea::make('description_en')->label(__('English Description'))->columnSpanFull(),
                ])->columns(2),
                Card::make()->schema([
                    SpatieMediaLibraryFileUpload::make('SpecialImage')
                        ->label(__('admin.SpecialImage'))
                        ->collection('SpecialImage'),
                    SpatieMediaLibraryFileUpload::make('SpecialImageEn')
                        ->label(__('admin.SpecialImageEn'))
                        ->collection('SpecialImageEn'),
                ]),

                Card::make()->schema([
                    Toggle::make('is_approved')->label(__('Is Confirmed?'))->columnSpanFull(),
                    Toggle::make('is_paid')->label(__('Paid'))->columnSpanFull(),
                    Textarea::make('message')->label(__('Message to user'))
                        ->helperText('در این قسمت چنانچه آگهی مورد تایید نبود دلیل عدم تایید را در این بخش بنویسید و دکمه ذخیره کردن را بزنید تا از طریق ایمیل به کاربر اطلاع رسانی شود.'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label(__('User'))
                    ->getStateUsing(function (TelegramAd $record) {
                        return $record->user?->name_with_role;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_id')
                    ->label(__('User'))
                    ->getStateUsing(function (TelegramAd $record) {
                        return ($record->category?->locale_name ?? '-');
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('Persian Description')),
                TextColumn::make('description_en')
                    ->label(__('English Description')),
                TextColumn::make('link')
                    ->label(__('Link')),
                BooleanColumn::make('is_approved')
                    ->label(__('admin.is_approved'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('is_paid')
                    ->label(__('admin.is_paid'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
            ])
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
            'index' => Pages\ListTelegramAds::route('/'),
            'create' => Pages\CreateTelegramAd::route('/create'),
            'edit' => Pages\EditTelegramAd::route('/{record}/edit'),
        ];
    }
}
