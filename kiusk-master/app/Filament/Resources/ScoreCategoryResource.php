<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScoreCategoryResource\Pages;
use App\Filament\Resources\ScoreCategoryResource\RelationManagers;
use App\Models\ScoreCategory;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScoreCategoryResource extends Resource
{
    protected static ?string $model = ScoreCategory::class;

    protected static ?string $label = 'نوع تخفیف ';

    protected static ?string $navigationLabel = 'نوع تخفیف ها ';

    protected static ?string $pluralLabel = 'نوع تخفیف ها ';

    protected static ?string $navigationGroup = 'امتیازات ';

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
                        Forms\Components\TextInput::make('name_en')->label(__('English Name'))->required(),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('require_score')->label(__('Require Score'))->default(1)->numeric()->required(),
                        Forms\Components\TextInput::make('discount_percentage')->label(__('Discount Percentage'))->default(1)->numeric()->required(),
                        Forms\Components\Toggle::make('is_active')->label(__('Active'))->inline()->default(1)->required(),
                    ]),
                    Forms\Components\Textarea::make('description')
                                        ->label(__('Description')),
                    Forms\Components\Textarea::make('description_en')
                                        ->label(__('English Description')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__("Persian Name"))->searchable()->sortable(),
                TextColumn::make('name_en')->label(__("English Name"))->searchable()->sortable(),
                ToggleColumn::make('is_active')->label(__("Active"))->searchable()->sortable(),
                TextColumn::make('require_score')->label(__("Require Score"))->searchable()->sortable(),
                TextColumn::make('description')->label(__("Persian Description"))->searchable()->sortable(),
                TextColumn::make('description_en')->label(__("English Description"))->searchable()->sortable(),

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
            'index' => Pages\ListScoreCategories::route('/'),
            'create' => Pages\CreateScoreCategory::route('/create'),
            'edit' => Pages\EditScoreCategory::route('/{record}/edit'),
        ];
    }
}
