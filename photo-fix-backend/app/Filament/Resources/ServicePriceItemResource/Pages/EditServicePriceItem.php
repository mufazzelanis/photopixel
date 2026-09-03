<?php

namespace App\Filament\Resources\ServicePriceItemResource\Pages;

use App\Filament\Resources\ServicePriceItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServicePriceItem extends EditRecord
{
    protected static string $resource = ServicePriceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
