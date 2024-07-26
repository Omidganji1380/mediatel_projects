<?php

namespace App\Filament\Resources\Address;

use App\Filament\Resources\Address\CityResource\Pages;
use App\Filament\Resources\Address\CityResource\RelationManagers;
use App\Models\Address\City;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Arr;
use Spatie\Tags\Tag;

class CityResource extends Resource
{
 use \App\Filament\Resources\Lib\Seo;

 protected static ?string $label = 'شهر ';
 protected static ?string $pluralLabel = 'شهر ها';
 protected static ?string $model = City::class;
 protected static ?string $navigationIcon = 'heroicon-o-collection';
 protected static ?string $recordTitleAttribute = 'name';
 protected static ?string $navigationGroup = 'بخش عمومی ';
 protected static ?int $navigationSort = 3;

 public static function form(Form $form): Form
 {
  return $form->schema([
                        TextInput::make('name')
                                 ->label(__('admin.name'))
                                 ->required(),
                        TextInput::make('slug')
                                 ->label(__('admin.slug'))
                                 ->required(),
                        BelongsToSelect::make('state_id')
                                       ->label(__('admin.state_id'))
                                       ->relationship('state', 'name'),
                        SpatieTagsInput::make('tags')
                                       ->label(__('admin.tags'))
                                       ->type('city')
                                       ->suggestions(function () {
                                        $vars = Tag::whereIn('type', [
                                         'city',
                                         'state'
                                        ])
                                                   ->get('name')
                                                   ->toArray();
                                        return Arr::flatten($vars);
                                       }),
                        SpatieMediaLibraryFileUpload::make('SpecialImage')
                                                    ->label(__('admin.SpecialImage'))
                                                    ->collection('SpecialImage')
                                                    ->columnSpan(3),
                        self::seoInputs('name')
                       ]);
 }

 public static function table(Table $table): Table
 {
  return $table->columns([
                          TextColumn::make('name')
                                    ->label(__('admin.name'))
                                    ->searchable()
                                    ->sortable(),
                          TextColumn::make('state.name')
                                    ->label(__('admin.state.name'))
                         ])
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
   'index' => Pages\ListCities::route('/'),
   'create' => Pages\CreateCity::route('/create'),
   'edit' => Pages\EditCity::route('/{record}/edit'),
  ];
 }
}
