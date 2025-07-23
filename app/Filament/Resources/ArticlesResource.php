<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticlesResource\Api\Transformers\ArticlesTransformer;
use App\Filament\Resources\ArticlesResource\Pages;
use App\Filament\Resources\ArticlesResource\Widgets\ArticlesChart;
use App\Models\ArticleLabels;
use App\Models\Articles;
use App\Models\Labels;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Label;

class ArticlesResource extends Resource
{
    protected static ?string $model = Articles::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static string|array $routeMiddleware = [];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('title')
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set('slug', str($state)->slug());
                        })
                        ->live(onBlur: true)
                        ->required(),
                    Forms\Components\Hidden::make('slug')
                        ->afterStateUpdated(function (Closure $set) {
                            $set('is_slug_changed_manually', true);
                        })
                        ->required(),
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload(
                            fn(Builder $query) => $query->where('role', '!=', 'admin')
                        )
                        ->options(User::all()->pluck('name', 'id'))
                        ->getOptionLabelUsing(fn(User $record) => "{$record->username} ({$record->name})")
                        ->required(),
                ]),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Select::make('category_id')
                    ->required()
                        ->relationship('category', 'name')
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->afterStateUpdated(function (Set $set, $state) {
                                    $set('slug', str($state)->slug());
                                })
                                ->live(onBlur: true)
                                ->required(),
                            Forms\Components\Hidden::make('slug')
                                ->afterStateUpdated(function (Closure $set) {
                                    $set('is_slug_changed_manually', true);
                                })->required(),
                        ])
                        ->createOptionUsing(function (array $data) {
                            return \App\Models\Categories::create($data)->getKey();
                        })
                        ->searchable()
                        ->preload(),



                    Select::make('labels')
                        ->relationship('labels', 'name') // this auto-loads id/name
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->required()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->afterStateUpdated(function (Set $set, $state) {
                                    $set('slug', str($state)->slug());
                                })
                                ->live(onBlur: true)
                                ->required(),
                            Forms\Components\Hidden::make('slug')
                                ->afterStateUpdated(function (Closure $set) {
                                    $set('is_slug_changed_manually', true);
                                })->required(),
                        ])
                    // ->createOptionUsing(function (array $data) {
                    //     return Labels::create($data)->getKey();
                    // }),
                ]),

                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\RichEditor::make('body')
                        ->toolbarButtons([
                            'attachFiles',
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h1',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->required(),
                    Forms\Components\Radio::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->inline()
                        ->inlineLabel(false)
                        ->required(),
                    Forms\Components\FileUpload::make('cover')
                        ->disk('public')
                        ->directory('cover')
                        ->visibility('public')
                        ->image()
                        ->required(),

                ]),


            ])->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->limit(30)
                    ->description(function (Model $record) {
                        return "Author: {$record->user->name}";
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('view')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->icon(function (string $state) {
                        return $state === 'draft' ? 'heroicon-s-pencil' : 'heroicon-s-check';
                    })
                    ->color(fn($state) => $state === 'draft' ? 'secondary' : 'success')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('labels.name')
                    ->color('warning')
                    ->searchable()
                ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                SelectFilter::make('category')->relationship('category', 'name')->multiple()->searchable()->preload(),

                // select filter form relation to article -> labels -> label for getting name
                SelectFilter::make('labels')
                    ->relationship('labels', 'name')
                    ->multiple()
                    ->searchable(),
                SelectFilter::make('status')
                    ->options(
                        [
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ]
                    )

            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticles::route('/create'),
            'edit' => Pages\EditArticles::route('/{record}/edit'),
        ];
    }

    public static function getApiTrasnformer()
    {
        return ArticlesTransformer::class;
    }
}
