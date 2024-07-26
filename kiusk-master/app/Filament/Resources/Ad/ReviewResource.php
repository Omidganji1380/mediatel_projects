<?php

namespace App\Filament\Resources\Ad;

use App\Filament\Resources\Ad\ReviewResource\Pages;
use App\Filament\Resources\Ad\ReviewResource\RelationManagers;
use App\Models\Ad\Review;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Lib\UserName;

class ReviewResource extends Resource
{
 use UserName;

 protected static ?string $label = 'بازبینی ';
 protected static ?string $pluralLabel = 'بازبینی ها';
 protected static ?string $model = Review::class;
 protected static ?string $navigationIcon = 'heroicon-o-annotation';
 protected static ?string $navigationGroup = 'بخش آگهی ';

 public static function form(Form $form): Form
 {
  $schema = [
   Toggle::make('is_visible')
         ->label(__('admin.is_visible'))
         ->inline(false),
//    TextInput::make('title')
//             ->label(__('admin.title'))
//             ->required(),
   Card::make()
       ->schema([
                 RichEditor::make('content')
                           ->label(__('admin.content'))
                           ->disableToolbarButtons([
                                                    'attachFiles',
                                                    'codeBlock',
                                                   ])
                ])
       ->columnSpan(3),
   self::userNameSelect(),
   BelongsToSelect::make('ad_id')
                  ->label(__('admin.ad_id'))
                  ->visible(fn(?Review $record): bool => $record?->ad ? false : true)
                  ->relationship('ad', 'title')
                  ->searchable(),
   Placeholder::make('ad_id')
              ->label(__('admin.ad_id'))
              ->content(fn(?Review $record): string => $record ? $record->ad?->title : '-')
              ->visible(fn(?Review $record): bool => $record?->ad ? true : false),
  ];
  return $form->schema($schema);
 }

 public static function table(Table $table): Table
 {
  $columns = [
   TextColumn::make('content')
             ->label(__('admin.content'))
             ->searchable()
             ->sortable(),
   BooleanColumn::make('is_visible')
                ->label(__('admin.is_visible'))
                ->trueIcon('heroicon-o-badge-check')
                ->falseIcon('heroicon-o-x-circle')
                ->sortable(),
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
   'index' => Pages\ListReviews::route('/'),
   'create' => Pages\CreateReview::route('/create'),
   'edit' => Pages\EditReview::route('/{record}/edit'),
  ];
 }
}
