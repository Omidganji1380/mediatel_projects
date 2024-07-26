<?php

namespace App\Filament\Resources\Payment\PaymentResource\Pages;

use App\Filament\Resources\Payment\PaymentResource;
use App\Models\Ad\Ad;
use App\Models\User;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord implements HasForms
{
 protected static string $resource = PaymentResource::class;
// use InteractsWithForms;
//
//  public function mount($record): void
// {
//  $this->form->fill([
//                     'upgrade' => true,
//
//                    ]);
// }
//
//
//
//
// protected function getFormSchema(): array
// {
//  return [
//   Select::make('payable_type')
//         ->label('نوع موردی قابل پرداخت ')
//         ->options([
//                    'ad' => 'آگهی',
//                   ])->default('ad')
//         ->required(),
////   TextInput::make('payable_id')
////            ->label('آیدی موردی قابل پرداخت ')
////            ->numeric()
////            ->required(),
//   Select::make('payable_id')
//         ->label('عنوان موردی قابل پرداخت ')
//         ->options(Ad::all()->pluck('title', 'id'))
//         ->searchable() ->required(),
//   Select::make('user_id')
//         ->label('کاربر')
//         ->options(User::all()->pluck('name', 'id'))
//         ->searchable()
//         ->required(),
////   BelongsToSelect::make('user_id')
////                  ->relationship('user', 'name')
////                  ->default(function () {
////                   return User::where('rule', 'admin')
////                              ?->first()?->id?:1;
////                  })
////                  ->required(),
//   TextInput::make('amount')
//            ->numeric()
//            ->required(),
//   Checkbox::make('upgrade')
//           ->label('نردبان')
//           ->required(),
//   Checkbox::make('special')
//           ->label('ویژه کردن')
//           ->required(),
//  ];
// }
//
//
// protected function mutateFormDataBeforeCreate(array $data): array
// {
//  $data['extra'] = [
//   'upgrade' => $data['upgrade'],
//
//   'special' => $data['special']
//  ];
//  return $data;
// }
}