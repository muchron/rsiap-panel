<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarouselResource\Api\Transformers\CarouselTransformer;
use App\Filament\Resources\CarouselResource\Pages;
use App\Models\Carousel;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class CarouselResource extends Resource
{
    protected static ?string $model = Carousel::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->schema([
                    TextInput::make('title')
                        ->required(),
                    FileUpload::make('image')
                        ->disk('public')
                        ->visibility('public')
                        ->image()
                        ->imageEditorAspectRatios(['1:1', '4:3', '16:9'])
                        ->imagePreviewHeight('500')
                        ->resize(50)
                        ->imageEditor()
                        ->optimize('webp')
                        ->directory('carousel'),
                    Toggle::make('is_active')
                        ->label('Status')
                        ->onColor('success')
                        ->offColor('danger')
                        ->onIcon('heroicon-m-check')
                        ->offIcon('heroicon-m-x-mark')
                        ->dehydrateStateUsing(fn($state): int => $state ? 1 : 0)
                        ->default(true),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                ImageColumn::make('image')->circular()->width(50)->height(50)
                    ->extraImgAttributes(['title' => 'Carousel Image'])
                    ->defaultImageUrl(asset('image/default-image.jpg')),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state == 1 ? 'Active' : 'Inactive')
                    ->color(fn($state) => $state == 1 ? 'success' : 'danger')
                    ->icon(fn($state) => $state == 1 ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle')
                    ->extraAttributes([
                        'class' => 'flex justify-center',
                    ])
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->dateTime(),


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
                Filter::make('is_active')
                    ->label('Status')
                    ->form([
                        Forms\Components\Toggle::make('is_active')
                    ])->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['is_active'],
                                fn(Builder $query): Builder => $query->where('is_active', $data['is_active']),
                            );
                    })
            ])
            ->actions([
                ActionGroup::make([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarousels::route('/'),
            'create' => Pages\CreateCarousel::route('/create'),
            'edit' => Pages\EditCarousel::route('/{record}/edit'),
        ];
    }

    public static function getApiTransformer()
    {
        return CarouselTransformer::class;
    }
}
