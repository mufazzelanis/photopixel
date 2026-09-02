<?php

namespace App\Filament\Resources\CtaBandResource\Pages;

use App\Filament\Resources\CtaBandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCtaBands extends ListRecords
{
    protected static string $resource = CtaBandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
