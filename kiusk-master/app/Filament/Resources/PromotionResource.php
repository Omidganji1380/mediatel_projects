<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionResource\Pages;
use App\Filament\Resources\PromotionResource\RelationManagers;
use App\Models\Promotion;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $label = 'پروموشن ';

    protected static ?string $navigationLabel = 'پروموشن ها ';

    protected static ?string $pluralLabel = 'پروموشن ها ';

    protected static ?string $navigationGroup = 'پروموشن ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('name')->label(__('Persian Name'))->required(),
                        Forms\Components\TextInput::make('name_en')->label(__('English Name'))->required()
                            ->reactive()
                            ->afterStateUpdated(function (Closure $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('slug')->label(__('Slug'))
                                        ->unique(ignorable: fn (?Model $record): ?Model => $record)
                                        ->required(),
                        Forms\Components\TextInput::make('url')->label(__('Url')),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\Select::make('background_color')->label(__('Background Color'))
                            ->options(Promotion::COLORS),
                        Forms\Components\Select::make('text_color')->label(__('Text Color'))
                            ->options(Promotion::COLORS),
                        Forms\Components\TextInput::make('icon')->label(__('Icon'))->placeholder('fa fa-star')
                            ->helperText('شما میتوانید از طریق <a href="https://fontawesome.com/icons" target="_blank">این سایت</a> آیکون مورد نظر را انتخاب کنید'),
                        Forms\Components\Toggle::make('is_visible')->label(__('admin.is_visible'))->inline()->default(1),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('position')
                                        ->numeric()
                                        ->minValue(0)
                                        ->default(0)
                                        ->label(__('Position')),

                    ]),
                    SpatieMediaLibraryFileUpload::make('SpecialImage')
                                    ->label(__('Special Image'))
                                    ->collection('SpecialImage'),

                    RichEditor::make('description')
                                        ->label(__('Description')),
                    RichEditor::make('description_en')
                                        ->label(__('English Description')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Persian Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_en')
                    ->label(__('English Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->label(__('Url'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('background_color')
                    ->label(__('Background Color'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('text_color')
                    ->label(__('Text Color'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('icon')
                    ->label(__('Icon'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('position')
                    ->label(__('Position'))
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_visible')
                            ->label(__('admin.is_visible')),
            ])
            ->defaultSort('updated_at', 'desc')
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
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotion::route('/create'),
            'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }
}
