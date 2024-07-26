<?php

namespace App\Filament\Resources\Address;

use App\Filament\Resources\Address\StateResource\Pages;
use App\Filament\Resources\Address\StateResource\RelationManagers;
use App\Models\Address\State;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\LinkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Arr;
use Spatie\Tags\Tag;

class StateResource extends Resource
{
 use \App\Filament\Resources\Lib\Seo;

 protected static ?string $label = 'استان ';
 protected static ?string $pluralLabel = 'استان ها';
 protected static ?string $model = State::class;
 protected static ?string $navigationIcon = 'heroicon-o-collection';
 protected static ?string $recordTitleAttribute = 'name';
 protected static ?string $navigationGroup = 'بخش عمومی ';
 protected static ?int $navigationSort = 2;

 public static function form(Form $form): Form
 {
  return $form->schema([
                        TextInput::make('name')
                                 ->label(__('admin.name'))
                                 ->required(),
                        TextInput::make('slug')
                                 ->label(__('admin.slug'))
                                 ->required(),
                        SpatieTagsInput::make('tags')
                                       ->label(__('admin.tags'))
                                       ->type('state')
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
                          TextColumn::make('cities_count')
                                    ->label(__('admin.cities_count'))
                                    ->counts('cities'),
                         ])
               ->filters([//
                         ]);
 }

 public static function getRelations(): array
 {
  return [//   RelationManagers\CitiesRelationManager::class,
  ];
 }

 public static function getPages(): array
 {
  return [
   'index' => Pages\ListStates::route('/'),
   'create' => Pages\CreateState::route('/create'),
   'edit' => Pages\EditState::route('/{record}/edit'),
  ];
 }
}
