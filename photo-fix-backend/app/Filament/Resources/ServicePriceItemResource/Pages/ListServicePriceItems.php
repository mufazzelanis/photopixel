<?php

namespace App\Filament\Resources\ServicePriceItemResource\Pages;

use App\Filament\Resources\ServicePriceItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServicePriceItems extends ListRecords
{
    protected static string $resource = ServicePriceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
