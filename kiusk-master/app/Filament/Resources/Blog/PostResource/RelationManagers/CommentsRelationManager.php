<?php

namespace App\Filament\Resources\Blog\PostResource\RelationManagers;

use App\Models\Blog\Comment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class CommentsRelationManager extends HasManyRelationManager
{
 protected static ?string $label = 'دیدگاه';
 protected static ?string $pluralLabel = 'دیدگاه ها';
 protected static string $relationship = 'comments';
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
   BelongsToSelect::make('user_id')
                  ->label(__('admin.user_id'))
                  ->visible(fn(?Comment $record): bool => $record?->user ? false : true)
                  ->relationship('user', 'name', fn(Builder $query) => $query->where('rule', 'admin'))
                  ->default(function () {
                   return User::where('rule', 'admin')
                              ->first()->id;
                  }),
   Placeholder::make('user_id')
              ->label(__('admin.user_id'))
              ->content(fn(?Comment $record): string => $record?->user?->name ? $record->user->name : '-')
              ->visible(fn(?Comment $record): bool => $record?->user ? true : false),
  ];
  return $form->schema($schema);
 }

 public static function table(Table $table): Table
 {
  $columns = [
   TextColumn::make('title')
             ->label(__('admin.title'))
             ->searchable()
             ->sortable(),
   BooleanColumn::make('is_visible')
                ->label(__('admin.is_visible'))
                ->trueIcon('heroicon-o-badge-check')
                ->falseIcon('heroicon-o-x-circle')
                ->sortable(),
   TextColumn::make('user.name')
             ->label(__('admin.user.name'))
             ->searchable()
             ->sortable(),
  ];
  return $table->columns($columns)
               ->filters([//
                         ]);
 }
}
