<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $label = 'بسته ';

    protected static ?string $navigationLabel = 'بسته ها ';

    protected static ?string $pluralLabel = 'بسته ها ';

    protected static ?string $navigationGroup = 'بخش فروش ';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('name_fa')->label(__('Name'))->required(),
                        Forms\Components\TextInput::make('name_en')->label(__('English Name'))->required(),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('slug')->label(__('Slug'))
                            ->unique(ignorable: fn (?Model $record): ?Model => $record)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                            ->columnSpan('full'),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('price')->label(__('Price'))->required(),
                        Forms\Components\Select::make('currency')->label(__('Currency'))
                            ->options(Plan::CURRENCIES)->default('CAD')->required(),
                        Forms\Components\TextInput::make('tax')->label(__('Taxes'))->numeric()->default(13),
                        Forms\Components\TextInput::make('discount_price')->label(__('Discount Price')),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\Select::make('model_type')->label(__('Plan Type'))
                            ->options(Plan::MODEL_TYPES)->required(),
                        Forms\Components\Select::make('type')->label(__('Type'))
                            ->options(Plan::TYPES)->required(),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('invoice_period')
                            ->numeric()
                            ->minValue(1)
                            ->label(__('Invoice Period'))->required(),
                        Forms\Components\Select::make('invoice_interval')->label(__('Invoice Interval'))
                            ->options(Plan::INTERVALS)->required(),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 2,
                    ])->schema([
                        Forms\Components\TextInput::make('limit')
                            ->numeric()
                            ->minValue(0)
                            ->label(__('Limit'))->required(),
                        Forms\Components\TextInput::make('position')
                            ->numeric()
                            ->minValue(0)
                            ->label(__('Position'))->required(),
                        Forms\Components\TextInput::make('featured_limit')
                            ->numeric()
                            ->minValue(0)
                            ->label(__('Featured Ads Limit'))->required(),
                        Forms\Components\Toggle::make('is_active')->label(__('Active'))->inline()->default(1)->required(),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 3,
                    ])->schema([
                        Forms\Components\Checkbox::make('show_in_main_page')
                            ->inline()
                            ->label(__('admin.show_in_main_page')),
                        Forms\Components\Checkbox::make('show_in_suggestion')
                            ->inline()
                            ->label(__('admin.show_in_suggestion')),
                        Forms\Components\Checkbox::make('show_in_sidebar')
                            ->inline()
                            ->label(__('admin.show_in_sidebar')),
                        Forms\Components\Checkbox::make('pin_ad')
                            ->inline()
                            ->label(__('admin.pin_ad')),
                        Forms\Components\Checkbox::make('motion_story')
                            ->inline()
                            ->label(__('admin.motion_story')),
                        Forms\Components\Checkbox::make('story')
                            ->inline()
                            ->label(__('admin.story')),
                        Forms\Components\Checkbox::make('free_blog_ad')
                            ->inline()
                            ->label(__('admin.free_blog_ad')),
                        Forms\Components\Checkbox::make('telegram_group_ad')
                            ->inline()
                            ->label(__('admin.telegram_group_ad')),
                        Forms\Components\Checkbox::make('telegram_channel')
                            ->inline()
                            ->label(__('admin.telegram_channel')),
                        Forms\Components\Checkbox::make('telegram_bot')
                            ->inline()
                            ->label(__('admin.telegram_bot')),
                        Forms\Components\Checkbox::make('narration')
                            ->inline()
                            ->label(__('admin.narration')),

                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 3,
                    ])->schema([
                        Forms\Components\Checkbox::make('email_notification')
                            ->inline()
                            ->label(__('Email Notification')),
                        Forms\Components\Checkbox::make('sms_notification')
                            ->inline()
                            ->label(__('Sms Notification')),
                        Forms\Components\Checkbox::make('vip')
                            ->inline()
                            ->label(__('admin.vip')),
                    ]),
                    Grid::make([
                        'sm' => 1,
                        'xl' => 1,
                    ])->schema([
                        Forms\Components\Checkbox::make('best_offer')
                            ->inline()
                            ->label(__('Best Offer')),
                    ]),
                    SpatieMediaLibraryFileUpload::make('BackgroundImage')
                        ->label(__('Background Image'))
                        ->collection('BackgroundImage'),

                    Forms\Components\Textarea::make('description')
                        ->label(__('Description')),
                    Forms\Components\Textarea::make('description_en')
                        ->label(__('English Description')),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_fa')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_en')
                    ->label(__('English Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->getStateUsing(function (Plan $record) {
                        return $record->price . " " . $record->currency;
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('invoice_period')
                    ->label(__('Period'))
                    ->getStateUsing(function (Plan $record) {
                        return $record->invoice_period . " " . Plan::INTERVALS[$record->invoice_interval];
                    })
                    ->searchable()
                    ->sortable(),
                BooleanColumn::make('show_in_main_page')
                    ->label(__('admin.show_in_main_page'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('show_in_sidebar')
                    ->label(__('admin.show_in_sidebar'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('show_in_suggestion')
                    ->label(__('admin.show_in_suggestion'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('pin_ad')
                    ->label(__('admin.pin_ad'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('telegram_channel')
                    ->label(__('admin.telegram_channel'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('vip')
                    ->label(__('admin.vip'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('motion_story')
                    ->label(__('admin.motion_story'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('story')
                    ->label(__('admin.story'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('free_blog_ad')
                    ->label(__('admin.free_blog_ad'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('telegram_group_ad')
                    ->label(__('admin.telegram_group_ad'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                BooleanColumn::make('best_offer')
                    ->label(__('admin.best_offer'))
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                TextColumn::make('limit')
                    ->label(__('Limit'))
                    ->searchable()
                    ->sortable(),
                // TextColumn::make('featured_limit')
                //     ->label(__('Featured Ads Limit'))
                //     ->searchable()
                //     ->sortable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->getStateUsing(function (Plan $record) {
                        return Plan::TYPES[$record->type];
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Plan Type'))
                    ->getStateUsing(function (Plan $record) {
                        return Plan::MODEL_TYPES[$record->model_type] ?? '-';
                    })
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('Active')),
                // BooleanColumn::make('is_active')
                //     ->action(function($record, $column) {
                //         $name = $column->getName();
                //         $record->update([
                //             $name => !$record->$name
                //         ]);
                //     })
                //     ->label(__('Active'))
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
