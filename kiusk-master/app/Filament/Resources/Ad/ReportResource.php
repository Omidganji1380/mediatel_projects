<?php

namespace App\Filament\Resources\Ad;

use App\Filament\Resources\Ad\ReportResource\Pages;
use App\Filament\Resources\Lib\UserName;
use App\Models\Ad\Report;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;

class ReportResource extends Resource
{
    use UserName;

    protected static ?string $label = 'گزارش ';
    protected static ?string $pluralLabel = 'گزارش ها';
    protected static ?string $model = Report::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-report';
    protected static ?string $navigationGroup = 'بخش آگهی ';

    public static function form(Form $form): Form
    {
        $schema = [
         TextInput::make('title')
                  ->label(__('admin.title'))
                  ->required(),
         self::userNameSelect(),
         BelongsToSelect::make('ad_id')
                        ->label(__('admin.ad_id'))
                        ->visible(fn (?Report $record): bool => $record?->ad ? false : true)
                        ->relationship('ad', 'title')
                        ->searchable(),
         Placeholder::make('ad_id')
                    ->label(__('admin.ad_id'))
                    ->content(fn (?Report $record): string => $record ? $record->ad?->title : '-')
                    ->visible(fn (?Report $record): bool => $record?->ad ? true : false),
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
         'index' => Pages\ListReports::route('/'),
         'create' => Pages\CreateReport::route('/create'),
         'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
