<?php

namespace App\Filament\Resources\Ad\AdResource\RelationManagers;

use App\Models\Ad\Review;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Lib\UserName;

class ReviewsRelationManager extends HasManyRelationManager
{
 use UserName;

 protected static ?string $label = 'بازبینی';
 protected static ?string $pluralLabel = 'بازبینی ها';
 protected static string $relationship = 'reviews';
 protected static ?string $recordTitleAttribute = 'title';

 public static function form(Form $form): Form
 {
  $schema = [
   Toggle::make('is_visible')
         ->label(__('admin.is_visible'))
         ->inline(false),
   TextInput::make('title')
            ->label(__('admin.title'))
            ->required(),
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
  ];
  return $table->columns($columns)
               ->filters([//
                         ]);
 }
}
