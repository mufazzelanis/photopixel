<?php

namespace App\Filament\Resources\WhyPointResource\Pages;

use App\Filament\Resources\WhyPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWhyPoints extends ListRecords
{
    protected static string $resource = WhyPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
