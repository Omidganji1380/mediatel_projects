<?php

namespace App\Filament\Resources\Ad;

use App\Filament\Resources\Ad\CategoryResource\Pages;
use App\Filament\Resources\Ad\CategoryResource\RelationManagers;
use App\Filament\Resources\Lib\Seo;
use App\Models\Ad\Category;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;
use Closure;

class CategoryResource extends Resource
{
    use Seo;

    protected static ?string $navigationLabel = 'دسته‌بندی ';
    protected static ?string $label = 'دسته‌بندی  ';
    protected static ?string $modelLabel  = 'دسته‌بندی  ';
    protected static ?string $pluralLabel = 'دسته‌بندی ها';
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'بخش آگهی ';

    public static function form(Form $form): Form
    {
        $schema = [
            Card::make()
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('name')
                                ->label(__('admin.name'))
                                ->required(),
                            //   ->reactive()
                            //   ->afterStateUpdated(fn ($state, callable $set) => $set(
                            //       'slug',
                            //       Str::slug($state)
                            //   )),
                            TextInput::make('name_en')
                                ->label(__('English Name'))
                                ->required(),
                            // ->reactive()
                            // ->afterStateUpdated(fn ($state, callable $set) => $set(
                            //     'slug',
                            //     Str::slug($state)
                            // )),
                            TextInput::make('slug')
                                ->label(__('admin.slug')),
                            // ->disabled()
                            // ->required()
                            // ->unique(Category::class, 'slug', fn ($record) => $record),
                            TextInput::make('emoji')
                                ->label(__('Emoji')),
                            Toggle::make('is_visible')
                                ->label(__('admin.is_visible'))
                                ->default(true),
                            Toggle::make('show_in_telegram')
                                ->label(__('Display in Telegram'))
                                ->default(true),
                            TextInput::make('position')
                                ->label(__('admin.position'))
                                ->default(0)
                                ->required()
                                ->numeric(),
                            Toggle::make('has_banner')
                                ->label(__('admin.has_banner'))
                                ->default(false),
                        ]),
                    BelongsToSelect::make('parent_id')
                        ->label(__('admin.parent_id'))
                        ->relationship('parent', 'name')
                        ->searchable()
                        ->placeholder('Select parent category'),

                    Select::make('type')
                        ->label(__('Type'))
                        ->options(Category::TYPES)
                        ->reactive(),
                    Select::make('sale_type')
                        ->label(__('Sale Type'))
                        ->options(Category::SALE_TYPES)
                        ->hidden(fn (Closure $get) => $get('type') !== 'real_estate'),
                    Select::make('property_type')
                        ->label(__('Property Type'))
                        ->options(Category::PROPERTY_TYPES)
                        ->hidden(fn (Closure $get) => $get('type') !== 'real_estate'),
                    TextInput::make('tag_line')
                        ->label(__('Tag Line')),
                    TextInput::make('tag_line_en')
                        ->label(__('English Tag Line')),
                    RichEditor::make('description')
                        ->label(__('admin.description'))
                        ->disableToolbarButtons([
                            'attachFiles',
                            'codeBlock',
                        ]),
                    RichEditor::make('description_en')
                        ->label(__('English Description'))
                        ->disableToolbarButtons([
                            'attachFiles',
                            'codeBlock',
                        ]),
                    RichEditor::make('full_description')
                        ->label(__('Persian Full Description'))
                        ->disableToolbarButtons([
                            'attachFiles',
                            'codeBlock',
                        ]),
                    RichEditor::make('full_description_en')
                        ->label(__('English Full Description'))
                        ->disableToolbarButtons([
                            'attachFiles',
                            'codeBlock',
                        ]),
                    SpatieTagsInput::make('tags')
                        ->label(__('admin.tags'))
                        ->type('ad')
                        ->suggestions(function () {
                            $vars = Tag::whereIn('type', [
                                'ad',
                                'adCategory',
                            ])
                                ->get('name')
                                ->toArray();

                            return Arr::flatten($vars);
                        }),
                    SpatieMediaLibraryFileUpload::make('SpecialImage')
                        ->label(__('admin.SpecialImage'))
                        ->collection('SpecialImage'),
                ])
                ->columnSpan(2),

            Section::make('بخش تبلیغات')
                ->schema([
                    Card::make()
                        ->schema([
                            Section::make(__('admin.HomeBGLarge_1'))
                                ->schema([
                                    Grid::make()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('HomeBGLarge_1')
                                            ->label(__('admin.HomeBGLarge_1'))
                                            ->collection('HomeBGLarge_1'),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.x')->label(__("admin.positions.fa.title_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.y')->label(__("admin.positions.fa.title_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.size')->label(__("admin.positions.fa.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.fa.title.color')->label(__('admin.positions.fa.title_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.align')->label(__("admin.positions.fa.title_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.valign')->label(__("admin.positions.fa.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.x')->label(__("admin.positions.fa.desc_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.y')->label(__("admin.positions.fa.desc_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.size')->label(__("admin.positions.fa.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.fa.description.color')->label(__(__('admin.positions.fa.description_color')))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.align')->label(__("admin.positions.fa.description_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.valign')->label(__("admin.positions.fa.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_1.x')->label(__("admin.positions.fa.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_1.y')->label(__("admin.positions.fa.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_1.size')->label(__("admin.positions.fa.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.fa.phone_1.color')->label(__('admin.positions.fa.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_1.align')->label(__("admin.positions.fa.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_1.valign')->label(__("admin.positions.fa.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_2.x')->label(__("admin.positions.fa.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_2.y')->label(__("admin.positions.fa.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_2.size')->label(__("admin.positions.fa.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.fa.phone_2.color')->label(__('admin.positions.fa.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_2.align')->label(__("admin.positions.fa.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.phone_2.valign')->label(__("admin.positions.fa.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.website.x')->label(__("admin.positions.fa.website_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.website.y')->label(__("admin.positions.fa.website_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.website.size')->label(__("admin.positions.fa.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.fa.website.color')->label(__('admin.positions.fa.website_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.website.align')->label(__("admin.positions.fa.website_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.website.valign')->label(__("admin.positions.fa.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.title.x')->label(__("admin.positions.en.title_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.title.y')->label(__("admin.positions.en.title_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.title.size')->label(__("admin.positions.en.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.en.title.color')->label(__('admin.positions.en.title_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.title.align')->label(__("admin.positions.en.title_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.title.valign')->label(__("admin.positions.en.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.description.x')->label(__("admin.positions.en.desc_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.description.y')->label(__("admin.positions.en.desc_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.description.size')->label(__("admin.positions.en.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.en.description.color')->label(__('admin.positions.en.description_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.description.align')->label(__("admin.positions.en.description_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.description.valign')->label(__("admin.positions.en.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_1.x')->label(__("admin.positions.en.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_1.y')->label(__("admin.positions.en.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_1.size')->label(__("admin.positions.en.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.en.phone_1.color')->label(__('admin.positions.en.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_1.align')->label(__("admin.positions.en.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_1.valign')->label(__("admin.positions.en.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_2.x')->label(__("admin.positions.en.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_2.y')->label(__("admin.positions.en.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_2.size')->label(__("admin.positions.en.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.en.phone_2.color')->label(__('admin.positions.en.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_2.align')->label(__("admin.positions.en.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.phone_2.valign')->label(__("admin.positions.en.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.website.x')->label(__("admin.positions.en.website_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.website.y')->label(__("admin.positions.en.website_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.website.size')->label(__("admin.positions.en.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.en.website.color')->label(__('admin.positions.en.website_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.website.align')->label(__("admin.positions.en.website_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.en.website.valign')->label(__("admin.positions.en.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                    ]),
                                ])->collapsed(),
                            Section::make(__('admin.HomeBGLarge_2'))
                                ->schema([
                                    Grid::make()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('HomeBGLarge_2')
                                            ->label(__('admin.HomeBGLarge_2'))
                                            ->collection('HomeBGLarge_2'),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.title.x')->label(__("admin.positions.fa.title_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.title.y')->label(__("admin.positions.fa.title_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.title.size')->label(__("admin.positions.fa.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.fa.title.color')->label(__('admin.positions.fa.title_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.title.align')->label(__("admin.positions.fa.title_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.title.valign')->label(__("admin.positions.fa.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.description.x')->label(__("admin.positions.fa.desc_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.description.y')->label(__("admin.positions.fa.desc_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.description.size')->label(__("admin.positions.fa.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.fa.description.color')->label(__('admin.positions.fa.description_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.description.align')->label(__("admin.positions.fa.description_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.description.valign')->label(__("admin.positions.fa.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_1.x')->label(__("admin.positions.fa.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_1.y')->label(__("admin.positions.fa.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_1.size')->label(__("admin.positions.fa.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.fa.phone_1.color')->label(__('admin.positions.fa.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_1.align')->label(__("admin.positions.fa.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_1.valign')->label(__("admin.positions.fa.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_2.x')->label(__("admin.positions.fa.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_2.y')->label(__("admin.positions.fa.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_2.size')->label(__("admin.positions.fa.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.fa.phone_2.color')->label(__('admin.positions.fa.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_2.align')->label(__("admin.positions.fa.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.phone_2.valign')->label(__("admin.positions.fa.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.website.x')->label(__("admin.positions.fa.website_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.website.y')->label(__("admin.positions.fa.website_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.website.size')->label(__("admin.positions.fa.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.fa.website.color')->label(__('admin.positions.fa.website_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.website.align')->label(__("admin.positions.fa.website_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.fa.website.valign')->label(__("admin.positions.fa.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.title.x')->label(__("admin.positions.en.title_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.title.y')->label(__("admin.positions.en.title_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.title.size')->label(__("admin.positions.en.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.en.title.color')->label(__('admin.positions.en.title_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.title.align')->label(__("admin.positions.en.title_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.title.valign')->label(__("admin.positions.en.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.description.x')->label(__("admin.positions.en.desc_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.description.y')->label(__("admin.positions.en.desc_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.description.size')->label(__("admin.positions.en.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.en.description.color')->label(__('admin.positions.en.description_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.description.align')->label(__("admin.positions.en.description_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.description.valign')->label(__("admin.positions.en.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_1.x')->label(__("admin.positions.en.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_1.y')->label(__("admin.positions.en.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_1.size')->label(__("admin.positions.en.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.en.phone_1.color')->label(__('admin.positions.en.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_1.align')->label(__("admin.positions.en.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_1.valign')->label(__("admin.positions.en.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_2.x')->label(__("admin.positions.en.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_2.y')->label(__("admin.positions.en.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_2.size')->label(__("admin.positions.en.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.en.phone_2.color')->label(__('admin.positions.en.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_2.align')->label(__("admin.positions.en.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.phone_2.valign')->label(__("admin.positions.en.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.website.x')->label(__("admin.positions.en.website_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.website.y')->label(__("admin.positions.en.website_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.website.size')->label(__("admin.positions.en.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_2.positions.en.website.color')->label(__('admin.positions.en.website_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.website.align')->label(__("admin.positions.en.website_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_2.positions.en.website.valign')->label(__("admin.positions.en.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                    ]),
                                ])->collapsed(),
                            Section::make(__('admin.BlogBottom_1'))
                                ->schema([
                                    Grid::make()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('BlogBottom_1')
                                            ->label(__('admin.BlogBottom_1'))
                                            ->collection('BlogBottom_1'),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.title.x')->label(__("admin.positions.fa.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.title.y')->label(__("admin.positions.fa.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.title.size')->label(__("admin.positions.fa.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.fa.title.color')->label(__('admin.positions.fa.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.title.align')->label(__("admin.positions.fa.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.title.valign')->label(__("admin.positions.fa.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.description.x')->label(__("admin.positions.fa.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.description.y')->label(__("admin.positions.fa.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.description.size')->label(__("admin.positions.fa.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.fa.description.color')->label(__('admin.positions.fa.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.description.align')->label(__("admin.positions.fa.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.description.valign')->label(__("admin.positions.fa.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_1.x')->label(__("admin.positions.fa.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_1.y')->label(__("admin.positions.fa.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_1.size')->label(__("admin.positions.fa.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.fa.phone_1.color')->label(__('admin.positions.fa.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_1.align')->label(__("admin.positions.fa.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_1.valign')->label(__("admin.positions.fa.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_2.x')->label(__("admin.positions.fa.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_2.y')->label(__("admin.positions.fa.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_2.size')->label(__("admin.positions.fa.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.fa.phone_2.color')->label(__('admin.positions.fa.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_2.align')->label(__("admin.positions.fa.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.phone_2.valign')->label(__("admin.positions.fa.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.website.x')->label(__("admin.positions.fa.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.website.y')->label(__("admin.positions.fa.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.website.size')->label(__("admin.positions.fa.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.fa.website.color')->label(__('admin.positions.fa.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.website.align')->label(__("admin.positions.fa.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.fa.website.valign')->label(__("admin.positions.fa.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.en.title.x')->label(__("admin.positions.en.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.title.y')->label(__("admin.positions.en.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.title.size')->label(__("admin.positions.en.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.en.title.color')->label(__('admin.positions.en.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.title.align')->label(__("admin.positions.en.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.title.valign')->label(__("admin.positions.en.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.en.description.x')->label(__("admin.positions.en.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.description.y')->label(__("admin.positions.en.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.description.size')->label(__("admin.positions.en.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.en.description.color')->label(__('admin.positions.en.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.description.align')->label(__("admin.positions.en.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.description.valign')->label(__("admin.positions.en.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_1.x')->label(__("admin.positions.en.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_1.y')->label(__("admin.positions.en.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_1.size')->label(__("admin.positions.en.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.en.phone_1.color')->label(__('admin.positions.en.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_1.align')->label(__("admin.positions.en.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_1.valign')->label(__("admin.positions.en.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_2.x')->label(__("admin.positions.en.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_2.y')->label(__("admin.positions.en.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_2.size')->label(__("admin.positions.en.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.en.phone_2.color')->label(__('admin.positions.en.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_2.align')->label(__("admin.positions.en.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.phone_2.valign')->label(__("admin.positions.en.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_1.positions.en.website.x')->label(__("admin.positions.en.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.website.y')->label(__("admin.positions.en.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.website.size')->label(__("admin.positions.en.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_1.positions.en.website.color')->label(__('admin.positions.en.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.website.align')->label(__("admin.positions.en.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_1.positions.en.website.valign')->label(__("admin.positions.en.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                    ]),
                                ])->collapsed(),
                            Section::make(__('admin.BlogBottom_2'))
                                ->schema([
                                    Grid::make()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('BlogBottom_2')
                                            ->label(__('admin.BlogBottom_2'))
                                            ->collection('BlogBottom_2'),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.x')->label(__("admin.positions.fa.title_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.y')->label(__("admin.positions.fa.title_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.size')->label(__("admin.positions.fa.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.fa.title.color')->label(__('admin.positions.fa.title_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.align')->label(__("admin.positions.fa.title_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.valign')->label(__("admin.positions.fa.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.x')->label(__("admin.positions.fa.desc_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.y')->label(__("admin.positions.fa.desc_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.size')->label(__("admin.positions.fa.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.fa.description.color')->label(__('admin.positions.fa.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.description.align')->label(__("admin.positions.fa.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.description.valign')->label(__("admin.positions.fa.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_1.x')->label(__("admin.positions.fa.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_1.y')->label(__("admin.positions.fa.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_1.size')->label(__("admin.positions.fa.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.fa.phone_1.color')->label(__('admin.positions.fa.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_1.align')->label(__("admin.positions.fa.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_1.valign')->label(__("admin.positions.fa.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_2.x')->label(__("admin.positions.fa.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_2.y')->label(__("admin.positions.fa.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_2.size')->label(__("admin.positions.fa.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.fa.phone_2.color')->label(__('admin.positions.fa.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_2.align')->label(__("admin.positions.fa.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.phone_2.valign')->label(__("admin.positions.fa.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.website.x')->label(__("admin.positions.fa.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.website.y')->label(__("admin.positions.fa.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.website.size')->label(__("admin.positions.fa.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.fa.website.color')->label(__('admin.positions.fa.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.website.align')->label(__("admin.positions.fa.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.fa.website.valign')->label(__("admin.positions.fa.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_2.positions.en.title.x')->label(__("admin.positions.en.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.title.y')->label(__("admin.positions.en.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.title.size')->label(__("admin.positions.en.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.en.title.color')->label(__('admin.positions.en.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.title.align')->label(__("admin.positions.en.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.title.valign')->label(__("admin.positions.en.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_2.positions.en.description.x')->label(__("admin.positions.en.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.description.y')->label(__("admin.positions.en.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.description.size')->label(__("admin.positions.en.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.en.description.color')->label(__('admin.positions.en.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.description.align')->label(__("admin.positions.en.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.description.valign')->label(__("admin.positions.en.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_1.x')->label(__("admin.positions.en.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_1.y')->label(__("admin.positions.en.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_1.size')->label(__("admin.positions.en.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.en.phone_1.color')->label(__('admin.positions.en.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_1.align')->label(__("admin.positions.en.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_1.valign')->label(__("admin.positions.en.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_2.x')->label(__("admin.positions.en.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_2.y')->label(__("admin.positions.en.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_2.size')->label(__("admin.positions.en.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.en.phone_2.color')->label(__('admin.positions.en.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_2.align')->label(__("admin.positions.en.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.phone_2.valign')->label(__("admin.positions.en.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogBottom_2.positions.en.website.x')->label(__("admin.positions.en.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.website.y')->label(__("admin.positions.en.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.website.size')->label(__("admin.positions.en.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogBottom_2.positions.en.website.color')->label(__('admin.positions.en.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.website.align')->label(__("admin.positions.en.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogBottom_2.positions.en.website.valign')->label(__("admin.positions.en.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                    ]),
                                ])->collapsed(),
                            Section::make(__('admin.BlogText_1'))
                                ->schema([
                                    Grid::make()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('BlogText_1')
                                            ->label(__('admin.BlogText_1'))
                                            ->collection('BlogText_1'),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.x')->label(__("admin.positions.fa.title_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.y')->label(__("admin.positions.fa.title_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.size')->label(__("admin.positions.fa.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.fa.title.color')->label(__('admin.positions.fa.title_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.align')->label(__("admin.positions.fa.title_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.valign')->label(__("admin.positions.fa.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.x')->label(__("admin.positions.fa.desc_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.y')->label(__("admin.positions.fa.desc_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.size')->label(__("admin.positions.fa.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.fa.description.color')->label(__('admin.positions.fa.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.fa.description.align')->label(__("admin.positions.fa.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.fa.description.valign')->label(__("admin.positions.fa.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_1.x')->label(__("admin.positions.fa.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_1.y')->label(__("admin.positions.fa.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_1.size')->label(__("admin.positions.fa.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.fa.phone_1.color')->label(__('admin.positions.fa.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_1.align')->label(__("admin.positions.fa.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_1.valign')->label(__("admin.positions.fa.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_2.x')->label(__("admin.positions.fa.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_2.y')->label(__("admin.positions.fa.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_2.size')->label(__("admin.positions.fa.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.fa.phone_2.color')->label(__('admin.positions.fa.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_2.align')->label(__("admin.positions.fa.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.fa.phone_2.valign')->label(__("admin.positions.fa.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_1.positions.fa.website.x')->label(__("admin.positions.fa.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.fa.website.y')->label(__("admin.positions.fa.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.fa.website.size')->label(__("admin.positions.fa.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.fa.website.color')->label(__('admin.positions.fa.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.fa.website.align')->label(__("admin.positions.fa.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.fa.website.valign')->label(__("admin.positions.fa.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_1.positions.en.title.x')->label(__("admin.positions.en.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.title.y')->label(__("admin.positions.en.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.title.size')->label(__("admin.positions.en.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.en.title.color')->label(__('admin.positions.en.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.en.title.align')->label(__("admin.positions.en.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.en.title.valign')->label(__("admin.positions.en.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_1.positions.en.description.x')->label(__("admin.positions.en.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.description.y')->label(__("admin.positions.en.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.description.size')->label(__("admin.positions.en.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.en.description.color')->label(__('admin.positions.en.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.en.description.align')->label(__("admin.positions.en.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.en.description.valign')->label(__("admin.positions.en.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_1.x')->label(__("admin.positions.en.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_1.y')->label(__("admin.positions.en.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_1.size')->label(__("admin.positions.en.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.en.phone_1.color')->label(__('admin.positions.en.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_1.align')->label(__("admin.positions.en.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_1.valign')->label(__("admin.positions.en.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_2.x')->label(__("admin.positions.en.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_2.y')->label(__("admin.positions.en.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_2.size')->label(__("admin.positions.en.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.en.phone_2.color')->label(__('admin.positions.en.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_2.align')->label(__("admin.positions.en.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.en.phone_2.valign')->label(__("admin.positions.en.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_1.positions.en.website.x')->label(__("admin.positions.en.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.website.y')->label(__("admin.positions.en.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_1.positions.en.website.size')->label(__("admin.positions.en.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_1.positions.en.website.color')->label(__('admin.positions.en.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_1.positions.en.website.align')->label(__("admin.positions.en.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_1.positions.en.website.valign')->label(__("admin.positions.en.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                    ]),
                                ])->collapsed(),
                            Section::make(__('admin.BlogText_2'))
                                ->schema([
                                    Grid::make()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('BlogText_2')
                                            ->label(__('admin.BlogText_2'))
                                            ->collection('BlogText_2'),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.x')->label(__("admin.positions.fa.title_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.y')->label(__("admin.positions.fa.title_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.size')->label(__("admin.positions.fa.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.HomeBGLarge_1.positions.fa.title.color')->label(__('admin.positions.fa.title_color'))->default('#000'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.align')->label(__("admin.positions.fa.title_align"))->default('right'),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.title.valign')->label(__("admin.positions.fa.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.x')->label(__("admin.positions.fa.desc_x"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.y')->label(__("admin.positions.fa.desc_y"))->numeric(),
                                                    TextInput::make('extra.HomeBGLarge_1.positions.fa.description.size')->label(__("admin.positions.fa.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.fa.description.color')->label(__('admin.positions.fa.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.fa.description.align')->label(__("admin.positions.fa.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.fa.description.valign')->label(__("admin.positions.fa.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_1.x')->label(__("admin.positions.fa.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_1.y')->label(__("admin.positions.fa.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_1.size')->label(__("admin.positions.fa.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.fa.phone_1.color')->label(__('admin.positions.fa.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_1.align')->label(__("admin.positions.fa.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_1.valign')->label(__("admin.positions.fa.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_2.x')->label(__("admin.positions.fa.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_2.y')->label(__("admin.positions.fa.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_2.size')->label(__("admin.positions.fa.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.fa.phone_2.color')->label(__('admin.positions.fa.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_2.align')->label(__("admin.positions.fa.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.fa.phone_2.valign')->label(__("admin.positions.fa.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_2.positions.fa.website.x')->label(__("admin.positions.fa.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.fa.website.y')->label(__("admin.positions.fa.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.fa.website.size')->label(__("admin.positions.fa.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.fa.website.color')->label(__('admin.positions.fa.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.fa.website.align')->label(__("admin.positions.fa.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.fa.website.valign')->label(__("admin.positions.fa.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_2.positions.en.title.x')->label(__("admin.positions.en.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.title.y')->label(__("admin.positions.en.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.title.size')->label(__("admin.positions.en.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.en.title.color')->label(__('admin.positions.en.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.en.title.align')->label(__("admin.positions.en.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.en.title.valign')->label(__("admin.positions.en.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_2.positions.en.description.x')->label(__("admin.positions.en.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.description.y')->label(__("admin.positions.en.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.description.size')->label(__("admin.positions.en.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.en.description.color')->label(__('admin.positions.en.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.en.description.align')->label(__("admin.positions.en.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.en.description.valign')->label(__("admin.positions.en.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_1.x')->label(__("admin.positions.en.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_1.y')->label(__("admin.positions.en.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_1.size')->label(__("admin.positions.en.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.en.phone_1.color')->label(__('admin.positions.en.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_1.align')->label(__("admin.positions.en.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_1.valign')->label(__("admin.positions.en.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_2.x')->label(__("admin.positions.en.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_2.y')->label(__("admin.positions.en.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_2.size')->label(__("admin.positions.en.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.en.phone_2.color')->label(__('admin.positions.en.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_2.align')->label(__("admin.positions.en.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.en.phone_2.valign')->label(__("admin.positions.en.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogText_2.positions.en.website.x')->label(__("admin.positions.en.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.website.y')->label(__("admin.positions.en.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogText_2.positions.en.website.size')->label(__("admin.positions.en.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogText_2.positions.en.website.color')->label(__('admin.positions.en.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogText_2.positions.en.website.align')->label(__("admin.positions.en.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogText_2.positions.en.website.valign')->label(__("admin.positions.en.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                    ]),
                                ])->collapsed(),
                            Section::make(__('admin.BlogSidebar_1'))
                                ->schema([
                                    Grid::make()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('BlogSidebar_1')
                                            ->label(__('admin.BlogSidebar_1'))
                                            ->collection('BlogSidebar_1'),
                                        Grid::make()
                                            ->schema([
                                                Grid::make()->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.title.x')->label(__("admin.positions.fa.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.title.y')->label(__("admin.positions.fa.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.title.size')->label(__("admin.positions.fa.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.fa.title.color')->label(__('admin.positions.fa.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.title.align')->label(__("admin.positions.fa.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.title.valign')->label(__("admin.positions.fa.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make()->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.description.x')->label(__("admin.positions.fa.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.description.y')->label(__("admin.positions.fa.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.description.size')->label(__("admin.positions.fa.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.fa.description.color')->label(__('admin.positions.fa.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.description.align')->label(__("admin.positions.fa.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.description.valign')->label(__("admin.positions.fa.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make()->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_1.x')->label(__("admin.positions.fa.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_1.y')->label(__("admin.positions.fa.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_1.size')->label(__("admin.positions.fa.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.fa.phone_1.color')->label(__('admin.positions.fa.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_1.align')->label(__("admin.positions.fa.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_1.valign')->label(__("admin.positions.fa.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make()->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_2.x')->label(__("admin.positions.fa.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_2.y')->label(__("admin.positions.fa.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_2.size')->label(__("admin.positions.fa.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.fa.phone_2.color')->label(__('admin.positions.fa.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_2.align')->label(__("admin.positions.fa.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.phone_2.valign')->label(__("admin.positions.fa.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make()->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.website.x')->label(__("admin.positions.fa.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.website.y')->label(__("admin.positions.fa.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.website.size')->label(__("admin.positions.fa.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.fa.website.color')->label(__('admin.positions.fa.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.website.align')->label(__("admin.positions.fa.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.fa.website.valign')->label(__("admin.positions.fa.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.title.x')->label(__("admin.positions.en.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.title.y')->label(__("admin.positions.en.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.title.size')->label(__("admin.positions.en.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.en.title.color')->label(__('admin.positions.en.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.title.align')->label(__("admin.positions.en.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.title.valign')->label(__("admin.positions.en.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.description.x')->label(__("admin.positions.en.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.description.y')->label(__("admin.positions.en.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.description.size')->label(__("admin.positions.en.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.en.description.color')->label(__('admin.positions.en.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.description.align')->label(__("admin.positions.en.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.description.valign')->label(__("admin.positions.en.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_1.x')->label(__("admin.positions.en.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_1.y')->label(__("admin.positions.en.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_1.size')->label(__("admin.positions.en.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.en.phone_1.color')->label(__('admin.positions.en.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_1.align')->label(__("admin.positions.en.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_1.valign')->label(__("admin.positions.en.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_2.x')->label(__("admin.positions.en.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_2.y')->label(__("admin.positions.en.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_2.size')->label(__("admin.positions.en.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.en.phone_2.color')->label(__('admin.positions.en.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_2.align')->label(__("admin.positions.en.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.phone_2.valign')->label(__("admin.positions.en.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.website.x')->label(__("admin.positions.en.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.website.y')->label(__("admin.positions.en.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.website.size')->label(__("admin.positions.en.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_1.positions.en.website.color')->label(__('admin.positions.en.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.website.align')->label(__("admin.positions.en.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_1.positions.en.website.valign')->label(__("admin.positions.en.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                    ]),
                                ])->collapsed(),
                            Section::make(__('admin.BlogSidebar_2'))
                                ->schema([
                                    Grid::make()
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('BlogSidebar_2')
                                            ->label(__('admin.BlogSidebar_2'))
                                            ->collection('BlogSidebar_2'),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.title.x')->label(__("admin.positions.fa.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.title.y')->label(__("admin.positions.fa.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.title.size')->label(__("admin.positions.fa.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.fa.title.color')->label(__('admin.positions.fa.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.title.align')->label(__("admin.positions.fa.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.title.valign')->label(__("admin.positions.fa.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.description.x')->label(__("admin.positions.fa.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.description.y')->label(__("admin.positions.fa.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.description.size')->label(__("admin.positions.fa.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.fa.description.color')->label(__('admin.positions.fa.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.description.align')->label(__("admin.positions.fa.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.description.valign')->label(__("admin.positions.fa.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_1.x')->label(__("admin.positions.fa.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_1.y')->label(__("admin.positions.fa.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_1.size')->label(__("admin.positions.fa.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.fa.phone_1.color')->label(__('admin.positions.fa.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_1.align')->label(__("admin.positions.fa.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_1.valign')->label(__("admin.positions.fa.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_2.x')->label(__("admin.positions.fa.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_2.y')->label(__("admin.positions.fa.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_2.size')->label(__("admin.positions.fa.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.fa.phone_2.color')->label(__('admin.positions.fa.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_2.align')->label(__("admin.positions.fa.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.phone_2.valign')->label(__("admin.positions.fa.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.website.x')->label(__("admin.positions.fa.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.website.y')->label(__("admin.positions.fa.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.website.size')->label(__("admin.positions.fa.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.fa.website.color')->label(__('admin.positions.fa.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.website.align')->label(__("admin.positions.fa.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.fa.website.valign')->label(__("admin.positions.fa.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                        Grid::make()
                                            ->schema([
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.title.x')->label(__("admin.positions.en.title_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.title.y')->label(__("admin.positions.en.title_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.title.size')->label(__("admin.positions.en.title_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.en.title.color')->label(__('admin.positions.en.title_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.title.align')->label(__("admin.positions.en.title_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.title.valign')->label(__("admin.positions.en.title_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.description.x')->label(__("admin.positions.en.desc_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.description.y')->label(__("admin.positions.en.desc_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.description.size')->label(__("admin.positions.en.description_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.en.description.color')->label(__('admin.positions.en.description_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.description.align')->label(__("admin.positions.en.description_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.description.valign')->label(__("admin.positions.en.description_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_1.x')->label(__("admin.positions.en.phone_1_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_1.y')->label(__("admin.positions.en.phone_1_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_1.size')->label(__("admin.positions.en.phone_1_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.en.phone_1.color')->label(__('admin.positions.en.phone_1_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_1.align')->label(__("admin.positions.en.phone_1_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_1.valign')->label(__("admin.positions.en.phone_1_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_2.x')->label(__("admin.positions.en.phone_2_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_2.y')->label(__("admin.positions.en.phone_2_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_2.size')->label(__("admin.positions.en.phone_2_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.en.phone_2.color')->label(__('admin.positions.en.phone_2_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_2.align')->label(__("admin.positions.en.phone_2_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.phone_2.valign')->label(__("admin.positions.en.phone_2_valign"))->default('middle'),
                                                ]),
                                                Grid::make(4)->schema([
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.website.x')->label(__("admin.positions.en.website_x"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.website.y')->label(__("admin.positions.en.website_y"))->numeric(),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.website.size')->label(__("admin.positions.en.website_size"))->default(18)->numeric(),
                                                    ColorPicker::make('extra.BlogSidebar_2.positions.en.website.color')->label(__('admin.positions.en.website_color'))->default('#000'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.website.align')->label(__("admin.positions.en.website_align"))->default('right'),
                                                    TextInput::make('extra.BlogSidebar_2.positions.en.website.valign')->label(__("admin.positions.en.website_valign"))->default('middle'),
                                                ]),
                                            ])->columns(4),
                                    ]),
                                ])->collapsed(),
                        ]),
                ])
                ->collapsed(),

            Card::make()
                ->schema([
                    Placeholder::make('created_at')
                        ->label(__('admin.created_at'))
                        ->content(fn (?Category $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    Placeholder::make('log.createdBy.name')
                        ->label(__('Created By'))
                        ->content(function (?Category $record) {
                            if ($record) {
                                if ($record->log?->createdBy?->name_with_role) {
                                    return new HtmlString(
                                        "<a href=\"" . route('filament.resources.users.edit', $record->log?->createdBy) . "\" class=\"text-primary-400\">{$record->log?->createdBy?->name_with_role}</a>"
                                    );
                                } elseif ($record->user) {
                                    return new HtmlString(
                                        "<a href=\"" . route('filament.resources.users.edit', $record->user) . "\" class=\"text-primary-400\">{$record->user?->name_with_role}</a>"
                                    );
                                }
                            }
                            return "-";
                        }),
                    Placeholder::make('updated_at')
                        ->label(__('admin.updated_at'))
                        ->content(fn (?Category $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    Placeholder::make('log.updatedBy.name')
                        ->label(__('Updated By'))
                        ->content(function (?Category $record) {
                            if ($record) {
                                if ($record->log?->updatedBy?->name_with_role) {
                                    return new HtmlString(
                                        "<a href=\"" . route('filament.resources.users.edit', $record->log?->updatedBy) . "\" class=\"text-primary-400\">{$record->log?->updatedBy?->name_with_role}</a>"
                                    );
                                }
                            }
                            return "-";
                        })
                ])
                ->columnSpan(1),
            self::seoInputs('name'),
        ];

        return $form->schema($schema)
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        $columns = [
            TextColumn::make('name')
                ->label(__('admin.name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('name_en')
                ->label(__('English Name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('parent.name')
                ->label(__('admin.parent.name'))
                ->searchable()
                ->sortable(),
            TextColumn::make('type')
                ->formatStateUsing(function ($state) {
                    return Category::TYPES[$state] ?? '-';
                })
                ->label(__('admin.category_type'))
                ->searchable()
                ->sortable(),
            BooleanColumn::make('is_visible')
                ->label(__('admin.is_visible'))
                ->sortable(),
            TextColumn::make('updated_at')
                ->formatStateUsing(function ($state) {
                    return jdate($state)->format('j F Y');
                })
                ->label(__('admin.updated_at'))
                ->sortable(),
        ];

        return $table->columns($columns)
            ->filters([ //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttributesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
