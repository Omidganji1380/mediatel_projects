<?php

namespace App\Filament\Resources\Ad\AdResource\RelationManagers;

use App\Filament\Resources\Ad\CategoryResource;
use App\Models\Ad\Category;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class CategoriesRelationManager extends BelongsToManyRelationManager
{
    protected static ?string $label = 'دسته‌بندی';
    protected static ?string $pluralLabel = 'دسته‌بندی ها';
    protected static string $relationship = 'categories';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return CategoryResource::form($form);
    }

    public static function table(Table $table): Table
    {
        $columns = [
            TextColumn::make('name')
                ->label(__('admin.name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('parent.name')
                ->label(__('admin.parent.name'))
                ->searchable()
                ->sortable(),
            //   TextColumn::make('parent_id')->$this->label(__('admin.parent_id')
            //             ->formatStateUsing(fn(string $state): string => dd($state)
            //  $state?
            //             Category::find($state)?->name:'-'
            // )
            //             ->searchable()
            //             ->sortable(),
            BooleanColumn::make('is_visible')
                ->label(__('admin.is_visible'))
                ->sortable(),
            BooleanColumn::make('is_main')
                ->label(__('admin.is_main'))
                ->sortable(),
            TextColumn::make('updated_at')
                ->label(__('admin.updated_at'))
                ->date()
                ->sortable(),
        ];
        return $table->columns($columns)
            ->filters([ //
            ]);
    }

    // public static function canDelete(Model $record): bool
    // {
    //     return false;
    // }

    public static function attachForm(Form $form): Form
    {
        return $form->schema([
            static::getAttachFormRecordSelect(),
            Forms\Components\Toggle::make('is_main')
                ->label(__('admin.is_main')),
            // ...
        ]);
    }
}
