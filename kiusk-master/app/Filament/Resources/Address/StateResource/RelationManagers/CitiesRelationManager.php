<?php

namespace App\Filament\Resources\Address\StateResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class CitiesRelationManager extends HasManyRelationManager
{
 protected static ?string $label = 'شهر';
 protected static ?string $pluralLabel = 'شهر ها';
 protected static string $relationship = 'cities';
 protected static ?string $recordTitleAttribute = 'name';

 public static function form(Form $form): Form
 {
  return $form->schema([
                        TextInput::make('name')
                                 ->label(__('admin.name'))
                                 ->required(),
                        TextInput::make('slug')
                                 ->label(__('admin.slug'))
                                 ->required(),
                       ]);
 }

 public static function table(Table $table): Table
 {
  return $table->columns([
                          TextColumn::make('name')
                                    ->label(__('admin.name'))
                                    ->searchable()
                                    ->sortable(),
                         ])
               ->filters([//
                         ]);
 }
}
