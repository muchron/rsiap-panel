<?php

namespace App\Filament\Resources\ApiServiceResource\Pages;

use App\Filament\Resources\ApiServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApiService extends EditRecord
{
    protected static string $resource = ApiServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
