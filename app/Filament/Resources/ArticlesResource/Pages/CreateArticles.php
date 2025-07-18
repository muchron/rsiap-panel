<?php

namespace App\Filament\Resources\ArticlesResource\Pages;

use App\Filament\Resources\ArticlesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticles extends CreateRecord
{
    protected static string $resource = ArticlesResource::class;

    protected function afrerSave(): void
    {
        dd($this->record);
        // $this->fillForm([
        //     'user_id' => auth()->user()->id,
        // ]);
    }
}
