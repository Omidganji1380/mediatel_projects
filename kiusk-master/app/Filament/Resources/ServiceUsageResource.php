<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceUsageResource\Pages;
use App\Filament\Resources\ServiceUsageResource\RelationManagers;
use App\Models\Ad\Ad;
use App\Models\ServiceUsage;
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

class ServiceUsageResource extends Resource
{
    protected static ?string $model = ServiceUsage::class;

    protected static ?string $label = 'استفاده از خدمات ';

    protected static ?string $navigationLabel = 'استفاده از خدمات ';

    protected static ?string $pluralLabel = 'استفاده از خدمات ';

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
                                ->content(function (?ServiceUsage $record) {
                                    if ($record) {
                                        if ($record->user?->name_with_role) {
                                            return new HtmlString(
                                                "<a href=\"" . route('filament.resources.users.edit', $record->user) . "\" class=\"text-primary-400\">{$record->user?->name_with_role}</a>"
                                            );
                                        }
                                    }
                                    return "-";
                                }),
                            Placeholder::make('ad')
                                ->label(__('admin.ad'))
                                ->content(function (?ServiceUsage $record) {
                                    if ($record) {
                                        if ($record->ad?->locale_title) {
                                            return new HtmlString(
                                                "<a href=\"" . route('filament.resources.ad/ads.edit', $record->ad) . "\" class=\"text-primary-400\">{$record->ad?->locale_title}</a>"
                                            );
                                        }
                                    }
                                    return "-";
                                }),
                        ]),
                    Placeholder::make('images')
                        ->label(__('admin.images'))
                        ->content(function (?ServiceUsage $record) {
                            if ($record) {
                                if ($record->getMedia('images')) {
                                    $html = '';
                                    foreach($record->getMedia('images') as $image){
                                        $html .= '<div class="col-md-4 col-12 p-3">
                                            <img src="' . $image->getUrl() . '" alt="" class="w-100">
                                        </div>';
                                    }
                                    return new HtmlString($html);
                                }
                            }
                            return "-";
                        }),
                    Placeholder::make('description')
                        ->label(__('admin.description'))
                        ->content(fn (?ServiceUsage $record): string => $record ? $record->description : 0),
                    Toggle::make('is_confirmed')->label(__('Is Confirmed?'))
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
                    ->getStateUsing(function (ServiceUsage $record) {
                        return $record->user->name_with_role ?? null;
                    })
                    ->url(fn (ServiceUsage $record) => route('filament.resources.users.edit', $record->user))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ad_id')
                    ->label(__('Ad'))
                    ->getStateUsing(function (ServiceUsage $record) {
                        return $record->ad->locale_title ?? null;
                    })
                    ->url(fn (ServiceUsage $record) => route('filament.resources.ad/ads.edit', $record->ad))
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
                SelectFilter::make('user_id')->label(__('Users'))
                    ->multiple()
                    ->options(User::select(DB::raw("IFNULL(NULLIF(name, ''), email) AS display_value"), 'id')
                        ->pluck('display_value', 'id')),
                SelectFilter::make('ad_id')->label(__('Ads'))
                    ->multiple()
                    ->options(Ad::pluck('title', 'id')),
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

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceUsages::route('/'),
            // 'create' => Pages\CreateServiceUsage::route('/create'),
            'edit' => Pages\EditServiceUsage::route('/{record}/edit'),
        ];
    }
}
