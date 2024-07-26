<?php

namespace App\Filament\Resources\Ad;

use App\Filament\Resources\Ad\AttributeResource\Pages;
use App\Models\Ad\Attribute;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class AttributeResource extends Resource
{
    protected static ?string $navigationLabel = 'ویژگی';
    protected static ?string $label = 'ویژگی ';
    protected static ?string $pluralLabel = 'ویژگی ها';
    protected static ?string $model = Attribute::class;
    protected static ?string $navigationIcon = 'heroicon-o-cloud';
    protected static ?string $navigationGroup = 'بخش آگهی ';

    public static function form(Form $form): Form
    {
        $schema = [
         TextInput::make('name')
                  ->label(__('admin.name'))
                  ->required(),
         Select::make('type')
               ->label(__('admin.type'))
               ->required()
               ->options([
                          'Text' => __('admin.text'),
//                    'Textarea' => 'Textarea',
//                    'Price' => 'Price',
//                    'Boolean' => 'Boolean',
                          'Select' => __('admin.select'),
//                    'Multiselect' => 'Multiselect',
//                    'Datetime' => 'Datetime',
//                    'Date' => 'Date',
//                    'Image' => 'Image',
//                    'File' => 'File',
//                    'Checkbox' => 'Checkbox',
                         ])
               ->afterStateUpdated(function (callable $set, $state) {
                   if ($state == 'Select' || $state == 'Multiselect') {
                   } else {
                       $set('options', null);
                   }
               })
               ->reactive(),
         /*   TagsInput::make('options')->$this->label(__('admin.options')
                     ->visible(function (callable $get, $state) {
                      return $get('type') == 'Select' || $get('type') == 'Multiselect';
                     })
                     ->required(),*/
         Repeater::make('options')
                 ->label(__('admin.options'))
                 ->schema([
                           TextInput::make('name')
                                    ->label(__('admin.name'))
                                    ->required(),
                          ])
                 ->visible(function (callable $get) {
            //            dd($get('type'));
                     return $get('type') == 'Select' || $get('type') == 'Multiselect';
                 }),
         TextInput::make('validation')
                  ->label(__('admin.validation')),
         TextInput::make('position')
                  ->label(__('admin.position'))
                  ->numeric(),
         Toggle::make('is_filterable')
               ->label(__('admin.is_filterable')),
         Toggle::make('is_visible_on_front')
               ->label(__('admin.is_visible_on_front')),
        ];

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        $columns = [
         TextColumn::make('name')
                   ->label(__('admin.name'))
                   ->sortable(),
         TextColumn::make('type')
                   ->label(__('admin.type'))
                   ->sortable(),
         BooleanColumn::make('is_visible_on_front')
                      ->label(__('admin.is_visible_on_front'))
                      ->sortable(),
         TextColumn::make('updated_at')
                   ->label(__('admin.updated_at'))
                   ->date()
                   ->sortable(),
        ];

        return $table->columns($columns)
                     ->filters([//
                               ]);
    }

    public static function getRelations(): array
    {
        return [//
        ];
    }

    public static function getPages(): array
    {
        return [
         'index' => Pages\ListAttributes::route('/'),
         'create' => Pages\CreateAttribute::route('/create'),
         'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
