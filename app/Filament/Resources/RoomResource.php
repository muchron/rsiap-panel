<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Layanan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        Section::make('Informasi Kamar')
                            ->description('Kelola identitas dan kategori kelas kamar.')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Ruangan')
                                            ->placeholder('Contoh: Ruang Ar-Raudhah 01')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(string $operation, $state, $set) =>
                                                $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                        TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->disabled()
                                            ->dehydrated()
                                            ->required(),

                                        Select::make('class')
                                            ->label('Kelas Layanan')
                                            ->options([
                                                'vvip' => 'VVIP',
                                                'vip' => 'VIP',
                                                'utama' => 'Utama',
                                                '1' => 'Kelas 1',
                                                '2' => 'Kelas 2',
                                                '3' => 'Kelas 3',
                                            ])
                                            ->native(false)
                                            ->required()
                                            ->preload(),

                                        Select::make('category')
                                            ->label('Kategori Ruangan')
                                            ->options([
                                                'Nifas' => 'Nifas',
                                                'Anak' => 'Anak',
                                                'Umum' => 'Umum',
                                            ])
                                            ->native(false)
                                            ->required()
                                            ->preload(),

                                        TextInput::make('price')
                                            ->label('Tarif per Hari')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->required(),
                                    ]),

                                Textarea::make('desc')
                                    ->label('Keterangan Kamar')
                                    ->placeholder('Jelaskan keunggulan kamar ini...')
                                    ->rows(4),
                            ]),

                        Section::make('Fasilitas Unggulan')
                            ->schema([
                                TagsInput::make('features')
                                    ->label('Daftar Fasilitas')
                                    ->placeholder('Ketik fasilitas (contoh: AC), lalu Enter')
                                    ->required(),
                            ]),
                    ])->columnSpan(['lg' => 2]),
                Grid::make(1)
                    ->schema([
                        Section::make('Visual & Status')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Foto Kamar')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('kamar')
                                    ->placeholder('Unggah foto kamar yang menarik...')
                                    ->resize(50)
                                    ->required(),

                                Select::make('color_theme')
                                    ->label('Warna Tema UI')
                                    ->options([
                                        'gold' => 'Emas (Luxury)',
                                        'blue' => 'Biru (Standard)',
                                        'green' => 'Hijau (Ekonomis)',
                                        'pink' => 'Pink (Khusus KIA)',
                                    ])
                                    ->default('blue')
                                    ->required(),

                                Toggle::make('is_available')
                                    ->label('Tersedia untuk Pasien')
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Foto')
                    ->rounded()
                    ->size(40),
                TextColumn::make('name')
                    ->label('Nama Kamar')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->slug),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->color(fn(string $state): string => match ($state) {
                        'Nifas' => 'success',
                        'Anak' => 'info',
                        'Umum' => 'warning',
                    })
                    ->badge()
                    ->sortable(),
                TextColumn::make('class')
                    ->label('Kelas')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'vvip' => 'gray',
                        'vip' => 'warning',
                        'utama' => 'primary',
                        '1' => 'info',
                        '2' => 'success',
                        '3' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),
                TextColumn::make('price')
                    ->label('Tarif/Hari')
                    ->money('IDR')
                    ->sortable(),
                ToggleColumn::make('is_available')
                    ->label('Tersedia'),
                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('class')
                    ->label('Filter Kelas')
                    ->options([
                        'vvip' => 'VVIP',
                        'vip' => 'VIP',
                        '1' => 'Kelas 1',
                        '2' => 'Kelas 2',
                        '3' => 'Kelas 3',
                    ]),
                SelectFilter::make('is_available')
                    ->label('Status')
                    ->options([
                        1 => 'Tersedia',
                        0 => 'Penuh',
                    ]),
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
