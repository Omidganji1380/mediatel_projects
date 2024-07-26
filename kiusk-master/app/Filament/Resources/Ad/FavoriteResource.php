<?php

namespace App\Filament\Resources\Ad;

use App\Filament\Resources\Ad\FavoriteResource\Pages;
use App\Filament\Resources\Ad\FavoriteResource\RelationManagers;
use App\Models\Ad\Favorite;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Lib\UserName;

class FavoriteResource extends Resource
{
 use UserName;

 protected static ?string $navigationLabel = 'علاقه‌مندی';
 protected static ?string $label = 'علاقه‌مندی ';
 protected static ?string $pluralLabel = 'علاقه‌مندی ها';
 protected static ?string $model = Favorite::class;
 protected static ?string $navigationIcon = 'heroicon-o-bookmark';
 protected static ?string $navigationGroup = 'بخش آگهی ';

 public static function form(Form $form): Form
 {
  $schema = [
   BelongsToSelect::make('ad_id')
                  ->label(__('admin.ad_id'))
                  ->visible(fn(?Favorite $record): bool => $record?->ad ? false : true)
                  ->relationship('ad', 'title')
                  ->searchable(),
   self::userNameSelect(),
   Placeholder::make('ad_id')
              ->label(__('admin.ad_id'))
              ->content(fn(?Favorite $record): string => $record ? $record->ad?->title : '-')
              ->visible(fn(?Favorite $record): bool => $record?->ad ? true : false),
  ];
  return $form->schema($schema);
 }

 public static function table(Table $table): Table
 {
  $columns = [
   self::userNameColumn(),
   TextColumn::make('ad.title')
             ->label(__('admin.ad.title'))
             ->url(function ($record) {
              return route('filament.resources.ad/ads.edit', $record);
             }, true)
             ->searchable()
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
   'index' => Pages\ListFavorites::route('/'),
   'create' => Pages\CreateFavorite::route('/create'),
   'edit' => Pages\EditFavorite::route('/{record}/edit'),
  ];
 }
}
