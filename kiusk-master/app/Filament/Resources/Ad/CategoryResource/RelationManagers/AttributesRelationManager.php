<?php

namespace App\Filament\Resources\Ad\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class AttributesRelationManager extends BelongsToManyRelationManager
{
 protected static ?string $label = 'ویژگی';
 protected static ?string $pluralLabel = 'ویژگی ها';
 protected static string $relationship = 'attrs';
 protected static ?string $recordTitleAttribute = 'name';

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
          }
          else {
           $set('options', null);
          }
         })
         ->reactive(),
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
}
