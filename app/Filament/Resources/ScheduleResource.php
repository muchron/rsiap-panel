<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('doctor_id')
                    ->searchable()
                    ->preload()
                    ->options(User::where('username', 'like', '1.%')->pluck('name', 'username'))
                    ->afterStateUpdated(function (Set $set, $state) {
                        $name = User::where('username', $state)->first();
                        $set('slug', str($name->name)->slug());
                    })
                    ->reactive()
                    ->live(onBlur: true)
                    ->required(),
                Forms\Components\Select::make('polyclinic_code')
                    ->name('polyclinic_code')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->options(\App\Models\Polyclinic::all()->pluck('name', 'code')),

                Forms\Components\Hidden::make('slug'),
                Forms\Components\Select::make('day')
                    ->options(
                        [
                            'Senin' => 'Senin',
                            'Selasa' => 'Selasa',
                            'Rabu' => 'Rabu',
                            'Kamis' => 'Kamis',
                            'Jumat' => 'Jumat',
                            'Sabtu' => 'Sabtu',
                            'Minggu' => 'Minggu',
                        ]
                    )
                    ->required(),
                Forms\Components\TimePicker::make('start_at')
                    ->required(),
                Forms\Components\TimePicker::make('end_at')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->required(),
            ])

        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('doctor')
                    ->formatStateUsing(function (Schedule $record) {
                        return $record->doctor?->user->name;
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('polyclinic.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('day')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->afterStateUpdated(function ($state, $record) {
                        Notification::make()
                            ->title('Status diperbarui')
                            ->body('Data ' . $record->name . ' sekarang ' . ($state ? 'aktif' : 'tidak aktif'))
                            ->success()
                            ->send();
                    }),
                Tables\Columns\TextColumn::make('start_at'),
                Tables\Columns\TextColumn::make('end_at'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                // Filter berdasarkan Dokter
                SelectFilter::make('doctor_id')
                    ->label('Dokter')
                    ->relationship('doctor', 'id')
                    ->searchable()
                    ->preload()
                    // 1. Logika untuk mencari nama saat user mengetik
                    ->getSearchResultsUsing(function (string $search): array {
                        return Doctor::whereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        })
                            ->with('user')
                            ->orderBy('name', 'ASC')
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn($doctor) => [$doctor->id => $doctor->user->name])
                            ->toArray();
                    })
                    // 2. Logika untuk menampilkan nama saat filter sudah dipilih (hydrate)
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name ?? 'Tidak Diketahui')

                    ->indicateUsing(function ($state): ?string {
                        if (blank($state)) {
                            return null;
                        }
                        $doctor = collect(Doctor::with('user')->find($state))->first();
                        return $doctor ? 'Dokter: ' . $doctor?->user?->name : null;
                    }),

                // Filter berdasarkan Poliklinik
                SelectFilter::make('polyclinic_id')
                    ->relationship('polyclinic', 'name') // 'polyclinic' adalah nama relasi, 'name' adalah kolom yang ditampilkan
                    ->label('Poliklinik')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
        ;
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }

    public static function getHandlers()
    {
        return [
            \App\Filament\Resources\ScheduleResource\Api\Handlers\IndexHandler::class,
            \App\Filament\Resources\ScheduleResource\Api\Handlers\DetailHandler::class,
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
