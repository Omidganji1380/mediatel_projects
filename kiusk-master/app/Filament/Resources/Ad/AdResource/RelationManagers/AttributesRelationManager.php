<?php

namespace App\Filament\Resources\Ad\AdResource\RelationManagers;

use App\Models\Ad\Attribute;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
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
 protected static ?string $inverseRelationship = 'ads';

 public static function form(Form $form): Form
 {
  return $form->schema([
                        TextInput::make('name')
                                 ->label(__('admin.name'))
                                 ->required(),
                        TextInput::make('validation')
                                 ->label(__('admin.validation')),
                        TextInput::make('position')
                                 ->label(__('admin.position'))
                                 ->numeric(),
                        Toggle::make('is_filterable')
                              ->label(__('admin.is_filterable')),
                        Toggle::make('is_visible_on_front')
                              ->label(__('admin.is_visible_on_front')),
                       ]);
 }

 public static function table(Table $table): Table
 {
  return $table->columns([
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
                         ])
               ->filters([//
                         ]);
 }

 public static function attachForm(Form $form): Form
 {
  $schema = [
   Select::make('recordId')
         ->label(__('admin.attribute'))
         ->options(function (callable $get) {
          return Attribute::all()
                          ->pluck('name', 'id')
                          ->toArray();
         })
         ->searchable()
         ->placeholder('Select  attribute')
         ->reactive(),
   TextInput::make('text')
            ->label(__('admin.text'))
            ->visible(function (callable $get) {
             return Attribute::find($get('recordId'))?->type == 'text';
            }),
   Toggle::make('boolean')
         ->label(__('admin.boolean'))
         ->visible(function (callable $get) {
          return Attribute::find($get('recordId'))?->type == 'boolean';
         }),
   TextInput::make('integer')
            ->label(__('admin.integer'))
            ->numeric()
            ->visible(function (callable $get) {
             return Attribute::find($get('recordId'))?->type == 'integer';
            }),
   TextInput::make('float')
            ->label(__('admin.float'))
            ->numeric()
            ->visible(function (callable $get) {
             return Attribute::find($get('recordId'))?->type == 'float';
            }),
   DateTimePicker::make('date_time')
                 ->label(__('admin.date_time'))
                 ->rules(['date_format:Y-m-d H:i:s'])
                 ->visible(function (callable $get) {
                  return Attribute::find($get('recordId'))?->type == 'date_time';
                 }),
   DatePicker::make('date')
             ->label(__('admin.date'))
             ->rules(['date'])
             ->visible(function (callable $get) {
              return Attribute::find($get('recordId'))?->type == 'date';
             }),
   TextInput::make('json')
            ->label(__('admin.json'))
            ->rules(['json'])
            ->visible(function (callable $get) {
             return Attribute::find($get('recordId'))?->type == 'json';
            }),
  ];
  return $form->schema($schema);
 }
}
