<?php

namespace App\Filament\Resources\Lib;

use App\Models\User;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Columns\TextColumn;

trait UserName
{
    public static function userNameSelect(): BelongsToSelect
    {
        return BelongsToSelect::make('user_id')
            ->label(__('admin.user_id'))
            ->relationship('user', 'name')
            ->searchable()
            ->default(fn () => auth()->id())
            ->helperText(function ($record) {
                if (!$record?->user?->name) {
                    return '-';
                }
                $user = $record->user;
                $route = route('filament.resources.users.edit', $user);
                $profile = $user->getFirstMedia('profile')?->getUrl('avatar');
                $name = $user->name;
                $name ? $name = 'نام کاربری : ' . $name . PHP_EOL : null;
                $first_name = $user->first_name;
                $first_name ? $first_name = 'نام : ' . $first_name . PHP_EOL : null;
                $last_name = $user->last_name;
                $last_name ? $last_name = 'نام خانوادگی : ' . $last_name . PHP_EOL : null;
                $phone = $user->phone;
                $phone ? $phone = 'تلفن : ' . $phone . PHP_EOL : null;
                $email = $user->email;
                $email ? $email = 'ایمیل : ' . $email : null;
                $title = $name . $first_name . $last_name . $phone . $email;
                $str4 = " $user->name";
                $str = "<a target='_top' title=\"$title\" href=\" ${route}\">";
                $str1 = "<img title=\"$title\" class=\"w-11 h-11 rounded-full bg-gray-200 bg-cover bg-center\" src='$profile'>";
                $str2 = "</a>";
                $str3 = $profile ? $str1 : $str4;
                return $str . $str3 . $str2;
            });
    }

    public static function userNameColumn(): TextColumn
    {
        return TextColumn::make('user.name')
            ->label(__('admin.user.name'))
            ->getStateUsing(fn ($record): ?string => $record->user?->name . ' - ' . (User::ROLES[$record->user?->rule ?: 'customer'] ?? __('messages.roles.customer')))
            ->url(function ($record) {
                if ($record->user) {
                    return route('filament.resources.users.edit', $record->user);
                }
                return null;
            })
            ->openUrlInNewTab()
            ->searchable()
            ->sortable();
    }
}
