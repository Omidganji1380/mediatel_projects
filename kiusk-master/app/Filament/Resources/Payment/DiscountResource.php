<?php

namespace App\Filament\Resources\Payment;

use Akaunting\Money\Money;
use App\Filament\Resources\Payment\DiscountResource\Pages;
use App\Filament\Resources\Payment\DiscountResource\RelationManagers;
use App\Models\Payment\Discount;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;

class DiscountResource extends Resource
{
    protected static ?string $label = 'کدتخفیف ';
    protected static ?string $pluralLabel = 'کدتخفیف ها';
    protected static ?string $model = Discount::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $recordTitleAttribute = 'code';
    protected static ?string $navigationGroup = 'بخش فروش ';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('code')
                ->label(__('admin.code'))
                ->unique(ignorable: fn (?Discount $record): ?Discount => $record)
                ->required(),
            TextInput::make('percent')
                ->label(__('admin.percent'))
                ->numeric(),
            TextInput::make('amount')
                ->label(__('admin.amount'))
                ->numeric(),
            Placeholder::make('useIt')
                ->label('استفاده شده در پرداخت')
                ->helperText(function (?Discount $record) {
                    $payment = $record?->payment;
                    if ($payment) {
                        $route = route('filament.resources.discounts.edit', $payment);
                        return "<a href='$route'>#$payment->id</a>";
                    }
                    return 'استفاده نشده است.';
                }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('code')
                ->label(__('admin.code'))
                ->searchable()
                ->sortable(),
            TextColumn::make('percent')
                ->label(__('admin.percent'))
                ->searchable()
                ->sortable(),
            TextColumn::make('amount')
                ->label(__('admin.amount'))
                ->formatStateUsing(function ($state) {
                    return Money::USD($state, true);
                })
                ->searchable()
                ->sortable(),
            BooleanColumn::make('payment_id')
                ->label(__('admin.payment_id'))
        ])
            ->filters([ //
            ]);
    }

    public static function getRelations(): array
    {
        return [ //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
