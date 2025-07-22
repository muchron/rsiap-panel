<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolyclinicResource\Pages;
use App\Filament\Resources\PolyclinicResource\RelationManagers;
use App\Models\Polyclinic;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PolyclinicResource extends Resource
{
    protected static ?string $model = Polyclinic::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')->required(),
                Forms\Components\TextInput::make('name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('code')->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->searchable(),
            ])
            ->filters([
                Filter::make('created_at')->form([
                    DatePicker::make('created_form'),
                    DatePicker::make('created_until')
                ])->query(function (Builder $query, array $data) {
                    return $query
                        ->when(
                            $data['created_form'],
                            fn(Builder $query, $date) => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn(Builder $query, $date) => $query->whereDate('created_at', '<=', $date),
                        );
                })


            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPolyclinics::route('/'),
            'create' => Pages\CreatePolyclinic::route('/create'),
            'edit' => Pages\EditPolyclinic::route('/{record}/edit'),
        ];
    }
}
