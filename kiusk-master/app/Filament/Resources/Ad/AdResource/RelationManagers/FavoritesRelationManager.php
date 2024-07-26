<?php

namespace App\Filament\Resources\Ad\AdResource\RelationManagers;

use App\Filament\Resources\Lib\UserName;
use App\Models\Ad\Favorite;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class FavoritesRelationManager extends HasManyRelationManager
{
 use UserName;

 protected static ?string $label = 'علاقه‌مندی';
 protected static ?string $pluralLabel = 'علاقه‌مندی ها';
 protected static string $relationship = 'favorites';
 protected static ?string $recordTitleAttribute = 'id';

 public static function form(Form $form): Form
 {
  $schema = [
   self::userNameSelect(),
  ];
  return $form->schema($schema);
 }

 public static function table(Table $table): Table
 {
  $columns = [
   self::userNameColumn(),
  ];
  return $table->columns($columns)
               ->filters([//
                         ]);
 }
}
