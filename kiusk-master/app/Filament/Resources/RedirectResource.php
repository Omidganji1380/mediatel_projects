<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Filament\Resources\RedirectResource\RelationManagers;
use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Blog\Post;
use App\Models\MainLink;
use App\Models\Redirect;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'ریدایرکت';

    protected static ?string $navigationLabel = 'ریدایرکت ها ';

    protected static ?string $pluralLabel = 'ریدایرکت ها ';

    protected static ?string $navigationGroup = 'تنظیمات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('from')->label('Old Url')->required(),
                    TextInput::make('to')->label('Redirect To Url')->required(),
                    TextInput::make('old_slug')->label('Old Slug'),
                    TextInput::make('new_slug')->label('New Slug'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('from')
                    ->label(__('Old Url'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('to')
                    ->label(__('Redirect Url'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('old_slug')
                    ->label(__('Old Slug'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('new_slug')
                    ->label(__('New Slug'))
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
