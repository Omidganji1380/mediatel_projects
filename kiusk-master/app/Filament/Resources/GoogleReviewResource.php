<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoogleReviewResource\Pages;
use App\Filament\Resources\GoogleReviewResource\RelationManagers;
use App\Models\GoogleReview;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class GoogleReviewResource extends Resource
{
    protected static ?string $model = GoogleReview::class;

    protected static ?string $label = 'نظرات گوگل ';

    protected static ?string $navigationLabel = 'نظرات گوگل ';

    protected static ?string $pluralLabel = 'نظرات گوگل ';

    protected static ?string $navigationGroup = 'امتیازات ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make(2)
                        ->schema([
                            Placeholder::make('user')
                                ->label(__('admin.user'))
                                ->content(function (?GoogleReview $record) {
                                    if ($record) {
                                        if ($record->user?->name_with_role) {
                                            return new HtmlString(
                                                "<a href=\"" . route('filament.resources.users.edit', $record->user) . "\" class=\"text-primary-400\">{$record->user?->name_with_role}</a>"
                                            );
                                        }
                                    }
                                    return "-";
                                }),
                            Placeholder::make('url')
                                ->label(__('admin.user'))
                                ->content(function (?GoogleReview $record) {
                                    if ($record) {
                                        if ($record->url) {
                                            return new HtmlString(
                                                "<a href=\"" . $record->url . "\" class=\"text-primary-400\">{$record->url}</a>"
                                            );
                                        }
                                    }
                                    return "-";
                                }),

                        ]),
                    Toggle::make('is_confirmed')->label(__('Is Confirmed?')),
                    Toggle::make('is_promoted')->label(__('Is Related to Mediatel?')),
                ]),
                Textarea::make('message')->label(__('Message to user')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label(__('User'))
                    ->getStateUsing(function (GoogleReview $record) {
                        return $record->user->name_with_role ?? null;
                    })
                    ->url(fn (GoogleReview $record) => route('filament.resources.users.edit', $record->user))
                    ->searchable()
                    ->sortable(),
                BooleanColumn::make('is_confirmed')
                    ->label(__('Confirmed'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Filter::make('is_confirmed')
                    ->label(__('Confirmed'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_confirmed', true)),
                Filter::make('not_confirmed')
                    ->label(__('Not Confirmed'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_confirmed', false)),
                Filter::make('is_promoted')
                    ->label(__('Review for Mediatel'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_promoted', true)),
                SelectFilter::make('user_id')->label(__('Users'))
                    ->multiple()
                    ->options(User::select(DB::raw("IFNULL(NULLIF(name, ''), email) AS display_value"), 'id')
                        ->pluck('display_value', 'id')),
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
            'index' => Pages\ListGoogleReviews::route('/'),
            'create' => Pages\CreateGoogleReview::route('/create'),
            'edit' => Pages\EditGoogleReview::route('/{record}/edit'),
        ];
    }
}
