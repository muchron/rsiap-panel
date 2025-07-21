<?php

namespace App\Filament\Resources\ApiServiceResource\Pages;

use App\Filament\Resources\ApiServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApiServices extends ListRecords
{
    protected static string $resource = ApiServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
