<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminReferralResource\Pages;
use App\Filament\Resources\AdminReferralResource\RelationManagers;
use App\Models\AdminReferral;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminReferralResource extends Resource
{
    protected static ?string $model = AdminReferral::class;

    protected static ?string $label = 'کد ارجاع ';

    protected static ?string $navigationLabel = 'کدهای ارجاع ';

    protected static ?string $pluralLabel = 'کدهای ارجاع ';

    protected static ?string $navigationGroup = 'بخش فروش ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')->label(__('admin.name')),
                    TextInput::make('code')->label(__('admin.code'))->required()->unique(ignorable: fn (?Model $record): ?Model => $record),
                    // TextInput::make('count')->label(__('admin.count')),
                    TextInput::make('score')->label(__('admin.score')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('admin.name')),
                TextColumn::make('code')->label(__('admin.code')),
                TextColumn::make('count')->label(__('admin.register_count')),
                TextColumn::make('score')->label(__('admin.score')),
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
            'index' => Pages\ListAdminReferrals::route('/'),
            'create' => Pages\CreateAdminReferral::route('/create'),
            'edit' => Pages\EditAdminReferral::route('/{record}/edit'),
        ];
    }
}
