<?php

namespace App\Filament\Resources\Ad\AdResource\RelationManagers;

use App\Models\Ad\Ad;
use App\Models\Ad\Report;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Filament\Resources\Lib\UserName;

class ReportsRelationManager extends HasManyRelationManager
{
 use UserName;

 protected static ?string $label = 'گزارش';
 protected static ?string $pluralLabel = 'گزارش ها';
 protected static string $relationship = 'reports';
 protected static ?string $recordTitleAttribute = 'id';

 public static function form(Form $form): Form
 {
  $schema = [
   TextInput::make('title')
            ->label(__('admin.title'))
            ->required(),
   self::userNameSelect(),
   Placeholder::make('user_id')
              ->label(__('admin.user_id'))
              ->content(fn(?Report $record): string => $record?->user?->name ? $record->user->name : '-')
              ->visible(fn(?Report $record): bool => $record?->user ? true : false),
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
   self::userNameColumn(),
  ];
  return $table->columns($columns)
               ->filters([//
                         ]);
 }
}
