<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\CommentResource\Pages;
use App\Filament\Resources\Blog\CommentResource\RelationManagers;
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
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Lib\UserName;

class CommentResource extends Resource
{
 use UserName;

 protected static ?string $label = 'دیدگاه ';
 protected static ?string $pluralLabel = 'دیدگاه ها';
 protected static ?string $model = Comment::class;
 protected static ?string $recordTitleAttribute = 'title';
 protected static ?string $navigationGroup = 'بخش وبلاگ ';
 protected static ?string $navigationIcon = 'heroicon-o-chat-alt-2';
 protected static ?int $navigationSort = 2;

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
   BelongsToSelect::make('post_id')
                  ->label(__('admin.post_id'))
                  ->visible(fn(?Comment $record): bool => $record?->post ? false : true)
                  ->relationship('post', 'title')
                  ->searchable(),
   Placeholder::make('post_id')
              ->label(__('admin.post_id'))
              ->content(fn(?Comment $record): string => $record ? $record->post?->title : '-')
              ->visible(fn(?Comment $record): bool => $record?->post ? true : false),
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
   self::userNameColumn(),
   TextColumn::make('post.title')
             ->label(__('admin.post.title'))
             ->url(function ($record) {
              return route('filament.resources.blog/posts.edit', $record);
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
   'index' => Pages\ListComments::route('/'),
   'create' => Pages\CreateComment::route('/create'),
   'edit' => Pages\EditComment::route('/{record}/edit'),
  ];
 }
}
