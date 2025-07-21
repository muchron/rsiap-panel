<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiServiceResource\Pages;
use App\Filament\Resources\ApiServiceResource\RelationManagers;
use App\Models\ApiService;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiServiceResource extends Resource
{
    protected static ?string $model = ApiService::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cons_id')
                    ->required()
                    ->default(fake()->randomNumber(6, true))
                    ->readOnly()
                    ->numeric(),
                Forms\Components\TextInput::make('api_key')
                    ->default(fake()->uuid())
                    ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('project')
                    ->required(),
                Forms\Components\Select::make('request_by')
                    // ->relationship('user', 'name')
                    ->label('Request By')
                    ->options(User::all()->pluck('name', 'username'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('created_by')
                    // ->relationship('user', 'name')
                    ->label('Created By')
                    ->options(User::all()->pluck('name', 'username'))
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cons_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('api_key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_by')
                    ->formatStateUsing(fn ($state) => \App\Models\User::where('username', $state)->first()->name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->formatStateUsing(fn ($state) => \App\Models\User::where('username', $state)->first()->name)
                    ->searchable(),
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
            'index' => Pages\ListApiServices::route('/'),
            'create' => Pages\CreateApiService::route('/create'),
            'edit' => Pages\EditApiService::route('/{record}/edit'),
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
