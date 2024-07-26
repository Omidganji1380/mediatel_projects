<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Forms\Components\AddressForm;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use LaravelIdea\Helper\App\Models\Address\_IH_City_QB;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class UserResource extends Resource
{
    protected static ?string $label = 'کاربر ';
    protected static ?string $pluralLabel = 'کاربران';
    protected static ?string $model = User::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationGroup = 'بخش عمومی ';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()
                ->schema([
                    TextInput::make('name')
                        ->label('نام کاربری')
                        ->required(),
                    TextInput::make('first_name')
                        ->label('نام'),
                    TextInput::make('last_name')
                        ->label('نام خانوادگی'),
                    TextInput::make('email')
                        ->label(__('admin.email'))
                        ->required()
                        ->email()
                        //                                       ->unique(ignorable: $ignoredUser)
                        //                                               ->rule(function (Component $livewire) {
                        //                                                if ($livewire instanceof Pages\CreateUser) {
                        //                                                 return 'unique:users,email';
                        //                                                }
                        //                                               })
                        //                                               ->rules(['unique:users,email'])
                        ->unique(ignorable: fn (?Model $record): ?Model => $record),
                    //                                               ->unique(Customer::class, 'email', fn($record) => $record),
                    TextInput::make('phone')
                        ->label(__('admin.phone')),
                    DatePicker::make('birthday')
                        ->label(__('admin.birthday')),
                    //                                      AddressForm::make('address')->$this->label(__('admin.address')
                    //                                                 ->columnSpan([
                    //                                                               'sm' => 2,
                    //                                                              ]),
                    SpatieMediaLibraryFileUpload::make('profile')
                        ->label(__('admin.profile'))
                        ->collection('profile'),
                    Forms\Components\Textarea::make('description')
                        ->label('توضیحات'),
                    Select::make('rule')
                        ->label('نقش')
                        ->options(User::ROLES)
                        ->required(),
                    Toggle::make('is_active')->inline(false)->label(__('admin.is_active'))->default(1)
                        ->helperText('چنانچه دکمه غیرفعال باشد به کاربران گزارشات روزانه، هفتگی و ماهانه ارسال نخواهد شد.'),
                ])
                ->columns([
                    'sm' => 2,
                ])
                ->columnSpan(2),
            Card::make()
                ->schema([
                    Placeholder::make('created_at')
                        ->label(__('admin.created_at'))
                        ->content(fn (?User $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('updated_at')
                        ->label(__('admin.updated_at'))
                        ->content(fn (?User $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    Placeholder::make('telegram_id')
                        ->label(__('admin.telegram_id'))
                        ->content(fn (?User $record): string => $record && $record->telegram_id ? $record->telegram_id : '-'),
                    Placeholder::make('telegram_first_name')
                        ->label(__('admin.telegram_first_name'))
                        ->content(fn (?User $record): string => $record && $record->telegram_first_name ? $record->telegram_first_name : '-'),
                    Placeholder::make('telegram_last_name')
                        ->label(__('admin.telegram_last_name'))
                        ->content(fn (?User $record): string => $record && $record->telegram_last_name ? $record->telegram_last_name : '-'),
                    Placeholder::make('telegram_username')
                        ->label(__('admin.telegram_username'))
                        ->content(fn (?User $record): string => $record && $record->telegram_username ? $record->telegram_username : '-'),
                    Placeholder::make('telegram_last_message')
                        ->label(__('admin.telegram_last_message'))
                        ->content(fn (?User $record): string => $record && $record->telegram_last_message ? $record->telegram_last_message : '-'),
                    Placeholder::make('scores')
                        ->label(__('admin.total_pending_scores'))
                        ->content(fn (?User $record): string => $record && $record->scores ? $record->totalNotClaimedScores()->sum('score') : 0),
                    Placeholder::make('scores')
                        ->label(__('admin.total_claimed_scores'))
                        ->content(fn (?User $record): string => $record && $record->scores ? $record->totalClaimedScores()->sum('score') : 0),
                    Placeholder::make('scores')
                        ->label(__('admin.total_spent_scores'))
                        ->content(fn (?User $record): string => $record && $record->scores ? $record->totalSpentScores()->sum('score') : 0),
                    //                                      Placeholder::make('telegram_last_method')
                    //                                                 ->label(__('admin.telegram_last_method'))
                    //                                                 ->content(fn(?User $record): string => $record && $record->telegram_last_method ? $record->telegram_last_method : '-'),
                    //                                      Placeholder::make('telegram_last_message_id')
                    //                                                 ->label(__('admin.telegram_last_message_id'))
                    //                                                 ->content(fn(?User $record): string => $record && $record->telegram_last_message_id ? $record->telegram_last_message_id : '-'),
                ])
                ->columnSpan(1),
            Card::make()
                ->schema([
                    //                                      BelongsToSelect::make('state_id')->$this->label(__('admin.state_id')
                    //                                                     ->relationship('state', 'name')
                    //                                                     ->searchable()
                    //                                                     ->preload(),
                    Select::make('state_id')
                        ->label(__('admin.state_id'))
                        ->options(function (callable $get) {
                            return State::all()
                                ->pluck('name', 'id')
                                ->toArray();
                        })
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                    Select::make('city_id')
                        ->label(__('admin.city_id'))
                        ->options(function (callable $get) {
                            $state = State::find($get('state_id'));
                            if (!$state) {
                                return City::all()
                                    ->pluck('name', 'id');
                            }
                            return $state->cities->pluck('name', 'id');
                        }),
                    //                                      BelongsToSelect::make('city_id')->$this->label(__('admin.city_id')
                    //                                                     ->relationship('city', 'name',
                    //                                                      function (callable $get, Builder $query) {
                    //                                                       if ($get('state_id')) {
                    //                                                        return $query->where('state_id', $get('state_id'));
                    //                                                       }
                    //                                                       return $query;
                    //                                                      })
                    //                                                     ->searchable()
                    //                                                     ->preload(),
                    TextInput::make('address')
                        ->label(__('admin.address')),
                ])
                ->columns([
                    'sm' => 2,
                ])
                ->columnSpan(2),
            Card::make()
                ->schema([
                    TextInput::make('password')
                        ->label(__('admin.password'))
                        ->password()
                        ->rules([Password::default()])
                        ->required(fn (Component $livewire): bool => $livewire instanceof Pages\CreateUser)
                        ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    //                                               ->visible(fn(Component $livewire): bool => $livewire instanceof Pages\CreateUser),
                    //
                ])
                //                            ->visible(fn(Component $livewire): bool => $livewire instanceof Pages\CreateUser)
                ->columns([
                    'sm' => 2,
                ])
                ->columnSpan(2),
            Card::make()
                ->schema([
                    SpatieMediaLibraryFileUpload::make('videos')
                        ->label(__('admin.videos'))
                        ->collection('videos'),
                ])
                ->columns([
                    'sm' => 1,
                ])
                ->columnSpan(2),
        ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->label(__('admin.name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('telegram_id')
                ->label(__('admin.telegram_id'))
                ->searchable()
                ->sortable(),
            TextColumn::make('telegram_first_name')
                ->label(__('admin.telegram_first_name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('telegram_last_name')
                ->label(__('admin.telegram_last_name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('telegram_username')
                ->label(__('admin.telegram_username'))
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->label(__('admin.email'))
                ->searchable()
                ->sortable(),
            TextColumn::make('phone')
                ->label(__('admin.phone'))
                ->searchable()
                ->sortable(),
            TextColumn::make('state')
                ->label(__('admin.state'))
                ->getStateUsing(fn ($record): ?string => $record->state?->name),
            TextColumn::make('rule')
                ->label(__('admin.rule'))
                ->enum([
                    'admin' => 'ادمین',
                    'super_admin' => 'سوپر ادمین',
                    'customer' => 'مشترک',
                    'seo' => 'مدیر سئو',
                    'author' => 'نویسنده',
                    'business_owner' => 'مالک بیزنس',
                    'seller' => 'فروشنده کالا',
                    'real_estate' => 'مشاور املاک',
                    'property_applicant' => 'متقاضی ملک',
                    'vip' => 'مشترک ویژه (VIP)',
                    '' => ''
                ])
                ->searchable()
                ->sortable(),
            TextColumn::make('created_at')
                ->label(__('admin.user_created_at'))
                ->searchable()
                ->sortable(),
        ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Filter::make('is_registered')
                    ->query(fn (Builder $query): Builder => $query->where('email', 'not like', '%@telegram.telegram%'))
                    ->label('ثبت نام شده')
            ])
            ->bulkActions([
                ExportBulkAction::make()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
