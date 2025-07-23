<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
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
                // Forms\Components\TextInput::make('doctor_id')
                //     ->required(),

                Forms\Components\Select::make('doctor_id')
                    ->searchable()
                    ->preload()
                    ->options(User::where('username', 'like', '1.%')->pluck('name', 'username'))
                    ->required(),
                Forms\Components\Select::make('polyclinic_code')
                    ->name('polyclinic_code')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->options(\App\Models\Polyclinic::all()->pluck('name', 'code')),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Doctor')
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
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
