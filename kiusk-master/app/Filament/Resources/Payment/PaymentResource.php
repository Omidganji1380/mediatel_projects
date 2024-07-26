<?php

namespace App\Filament\Resources\Payment;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Filament\Resources\Payment\PaymentResource\Pages;
use App\Filament\Resources\Payment\PaymentResource\RelationManagers;
use App\Models\Ad\Ad;
use App\Models\Ad\Favorite;
use App\Models\Payment\Discount;
use App\Models\Payment\Payment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Lib\UserName;

class PaymentResource extends Resource
{
 use UserName;

 protected static ?string $label = 'پرداخت ';
 protected static ?string $pluralLabel = 'پرداخت ها';
 protected static ?string $model = Payment::class;
 protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
 protected static ?string $recordTitleAttribute = 'id';
 protected static ?string $navigationGroup = 'بخش فروش ';
 protected static ?int $navigationSort = 1;

 public static function form(Form $form): Form
 {
  return $form->schema([
                        Select::make('payable_type')
                              ->label(__('admin.payable_type'))
                              ->options([
                                         'ad' => 'آگهی',
                                        ])
                              ->required(),
                        Select::make('payable_id')
                              ->label(__('admin.payable_id'))
                              ->options(Ad::all()
                                          ->pluck('title', 'id'))
                              ->searchable()
                              ->required(),
                        Select::make('status')
                              ->label(__('admin.status'))
                              ->options([
                                         'complete' => 'کامل',
                                         'incomplete' => 'ناقص'
                                        ])
                              ->searchable()
                              ->required(),
                        self::userNameSelect(),
                        TextInput::make('amount')
                                 ->label(__('admin.amount'))
                                 ->numeric()
                                 ->required(),
//                        Checkbox::make('extra.upgrade'
//                                ->required(),
//                        Checkbox::make('special'
//                                ->required(),
                       ]);
 }

 public static function table(Table $table): Table
 {
  return $table->columns([
                          TextColumn::make('payable_type')
                                    ->label(__('admin.payable_type'))
                                    ->enum([
                                            'ad' => 'آگهی',
                                            'user' => 'کاربر',
                                           ])
                                    ->searchable()
                                    ->sortable(),
                          self::userNameColumn(),
                          TextColumn::make('amount')
                                    ->label(__('admin.amount'))
                                    ->formatStateUsing(function ($state) {
                                     return Money::USD($state, true);
                                    })
                                    ->searchable()
                                    ->sortable(),
                          TextColumn::make('status')
                                    ->label(__('admin.status'))
                                    ->enum([
                                            'incomplete' => 'ناقص',
                                            'complete' => 'کامل',
                                           ])
                                    ->searchable()
                                    ->sortable(),
                         ])
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
   'index' => Pages\ListPayments::route('/'),
   'create' => Pages\CreatePayment::route('/create'),
   'edit' => Pages\EditPayment::route('/{record}/edit'),
  ];
 }
}
