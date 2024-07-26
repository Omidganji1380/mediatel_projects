<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScoreResource\Pages;
use App\Filament\Resources\ScoreResource\RelationManagers;
use App\Models\Score;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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

class ScoreResource extends Resource
{
    protected static ?string $model = Score::class;

    protected static ?string $label = 'امتیاز ';

    protected static ?string $navigationLabel = 'امتیازات ';

    protected static ?string $pluralLabel = 'امتیازات ';

    protected static ?string $navigationGroup = 'امتیازات ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Placeholder::make('user')
                            ->label(__('admin.user'))
                            ->content(function (?Score $record) {
                                if ($record) {
                                    if ($record->user?->name_with_role) {
                                        return new HtmlString(
                                            "<a href=\"" . route('filament.resources.users.edit', $record->user) . "\" class=\"text-primary-400\">{$record->user?->name_with_role}</a>"
                                        );
                                    }
                                }
                                return "-";
                            }),
                        Placeholder::make('current_role')
                            ->label(__('admin.current_role'))
                            ->content(fn (?Score $record): string => $record ? __('messages.roles.' . $record->current_role) : '-'),
                        Placeholder::make('type')
                            ->label(__('admin.type'))
                            ->content(fn (?Score $record): string => $record ? __('messages.scores.types.' . $record->type) : '-'),
                        Placeholder::make('score')
                            ->label(__('admin.score'))
                            ->content(fn (?Score $record): string => $record ? $record->score : 0),
                        Toggle::make('claimed')
                            ->label(__('admin.claimed')),
                        Toggle::make('spent')
                            ->label(__('admin.spent')),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan(2),
                Card::make()
                    ->schema([
                        Placeholder::make('created_at')
                            ->label(__('admin.created_at'))
                            ->content(fn (?Score $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                        Placeholder::make('updated_at')
                            ->label(__('admin.updated_at'))
                            ->content(fn (?Score $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        Placeholder::make('spent_date')
                            ->label(__('admin.spent_date'))
                            ->content(fn (?Score $record): string => $record ? ($record->spent_date?->format('Y-m-d HH:MM') ?? '-' ) : '-'),
                    ])
                    ->columnSpan(1),
                Textarea::make('message')->label(__('Message to user')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label(__('admin.type'))
                    ->getStateUsing(function (Score $record) {
                        return __('messages.scores.types.' . $record->type);
                    })
                    ->searchable()
                    ->sortable(),
                BooleanColumn::make('claimed')
                    ->label(__('admin.claimed'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('spent')
                    ->label(__('admin.spent'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                TextColumn::make('user_id')
                    ->label(__('User'))
                    ->getStateUsing(function (Score $record) {
                        return $record->user->name_with_role ?? null;
                    })
                    ->url(fn (Score $record) => route('filament.resources.users.edit', $record->user))
                    ->searchable()
                    ->sortable(),
            ])->defaultSort('created_at', 'desc')
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
                Filter::make('claimed')
                    ->label(__('Claimed Score'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('claimed', true)),
                Filter::make('not_claimed')
                    ->label(__('Pending Scores'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('claimed', false)),
                Filter::make('spent')
                    ->label(__('Spent Scores'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('spent', true)),
                SelectFilter::make('user_id')->label(__('Users'))
                    ->multiple()
                    ->options(User::select(DB::raw("IFNULL(NULLIF(name, ''), email) AS display_value"), 'id')
                        ->pluck('display_value', 'id')),
                SelectFilter::make('type')->label(__('Types'))
                    ->multiple()
                    ->options(Score::TYPES),
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

    public static function canCreate(): bool {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScores::route('/'),
            // 'create' => Pages\CreateScore::route('/create'),
            'edit' => Pages\EditScore::route('/{record}/edit'),
        ];
    }
}
