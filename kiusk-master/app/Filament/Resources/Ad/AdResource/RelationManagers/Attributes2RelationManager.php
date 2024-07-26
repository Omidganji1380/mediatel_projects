<?php

namespace App\Filament\Resources\Ad\AdResource\RelationManagers;

use App\Models\Ad\AdAttribute;
use App\Models\Ad\Attribute;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class Attributes2RelationManager extends HasManyRelationManager
{
 protected static ?string $label = 'ویژگی';
 protected static ?string $pluralLabel = 'ویژگی ها';
 protected static string $relationship = 'attrs2';
 protected static ?string $recordTitleAttribute = 'id';

 public static function form(Form $form): Form
 {
  $schema = [
   Select::make('ad_attribute_id')
         ->label(__('admin.attribute'))
         ->options(function (callable $get) {
          return Attribute::all()
                          ->pluck('name', 'id')
                          ->toArray();
         })
         ->searchable()
         ->placeholder('Select  attribute')
         ->disabled(function (callable $get) {
          return $get('ad_attribute_id') !== null;
         })
         ->reactive(),
   TextInput::make('text')
//    ->mutateDehydratedStateUsing(function ($record,$state) {
////     dump($record);
////     return 'ssssssssssssss';
//     return $state;
//    })
            ->label(function (callable $get) {
     return Attribute::find($get('ad_attribute_id'))?->name;
    })
            ->hidden(function ($record) {
//             dump('aaaaaaaaa');
             return $record->attribute->type == 'Text';
            }),
   Textarea::make('text')
           ->label(function (callable $get) {
            return Attribute::find($get('ad_attribute_id'))?->name;
           })
           ->visible(function ($record) {
            return $record->attribute->type == 'Textarea';
           }),
   TextInput::make('integer')
            ->label(function (callable $get) {
             return Attribute::find($get('ad_attribute_id'))?->name;
            })
            ->numeric()
            ->visible(function ($record) {
             return $record->attribute->type == 'Price';
            }),
   Toggle::make('boolean')
         ->label(function (callable $get) {
          return Attribute::find($get('ad_attribute_id'))?->name;
         })
         ->visible(function ($record) {
          return $record->attribute->type == 'Boolean';
         }),
   /*   TextInput::make('float')
               ->label(function (callable $get) {
                return Attribute::find($get('ad_attribute_id'))?->name;
               })
               ->numeric()
               ->visible(function ($record) {
                return $record->attribute->type == 'float';
               }),*/
   Select::make('text')
         ->options(function (callable $get) {
          return Attribute::find($get('ad_attribute_id'))?->options_array;
         })
         ->label(function (callable $get) {
          return Attribute::find($get('ad_attribute_id'))?->name;
         })
         ->visible(function ($record) {
          return $record->attribute->type == 'Select';
         }),
   MultiSelect::make('json')
              ->options(function (callable $get) {
//               return [
//                'tailwind' => 'TailwindCSS',
//                'alpine' => 'Alpine.js',
//                'laravel' => 'Laravel',
//                'livewire' => 'Laravel Livewire',
//               ];
               return Attribute::find($get('ad_attribute_id'))?->options_array;
              })
              ->label(function (callable $get) {
               return Attribute::find($get('ad_attribute_id'))?->name;
              })
              ->visible(function ($record) {
               return $record->attribute->type == 'Multiselect';
              }),
   DateTimePicker::make('date_time')
                 ->label(function (callable $get) {
                  return Attribute::find($get('ad_attribute_id'))?->name;
                 })
                 ->format('Y-m-d H:i:s')
                 ->displayFormat('Y-m-d H:i:s')
                 ->rules(['date_format:Y-m-d H:i:s'])
                 ->visible(function ($record) {
                  return $record->attribute->type == 'Datetime';
                 }),
   DatePicker::make('date')
             ->format('Y-m-d')
             ->displayFormat('Y-m-d')
             ->label(function (callable $get) {
              return Attribute::find($get('ad_attribute_id'))?->name;
             })
             ->rules(['date'])
             ->visible(function ($record) {
              return $record->attribute->type == 'Date';
             }),
   FileUpload::make('text')
             ->image()
             ->label(function (callable $get) {
              return Attribute::find($get('ad_attribute_id'))?->name;
             })
             ->visible(function ($record) {
              return $record->attribute->type == 'Image';
             }),
   FileUpload::make('text')
             ->label(function (callable $get) {
              return Attribute::find($get('ad_attribute_id'))?->name;
             })
             ->visible(function ($record) {
              return $record->attribute->type == 'File';
             }),
   Checkbox::make('boolean')
           ->label(function (callable $get) {
            return Attribute::find($get('ad_attribute_id'))?->name;
           })
           ->visible(function ($record) {
            return $record->attribute->type == 'Checkbox';
           }),
  ];
  return $form->schema($schema);
 }

 public static function table(Table $table): Table
 {
  return $table->columns([
                          TextColumn::make('attribute.name')
                                    ->label(__('admin.Attribute_Name'))
                                    ->searchable()
                                    ->sortable(),
                          TextColumn::make('text')
                                    ->label('مقدار')
                                    ->searchable()
                                    ->sortable(),
                          TextColumn::make('attribute.type')
                                    ->label(__('admin.Attribute_Type'))
                                    ->enum([
                                            'Text' => 'متن',
                                            'Select' => 'انتخاب',
                                           ])
                                    ->searchable()
                                    ->sortable(),
                         ])
               ->filters([//
                         ]);
 }
}
